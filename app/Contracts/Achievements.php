<?php

namespace App\Contracts;

use Exception;

abstract class Achievements
{

    /**
     * model
     *
     * @var string
     */
    public $model;

    /**
     * modelProgress
     *
     * @var string
     */
    public $modelProgress;

    /**
     * modelProgressRelationNameWithModel
     *
     * @var string
     */
    public $modelProgressRelationNameWithModel = 'achievement';

    /**
     * name
     *
     * @var string
     */
    public $name = "Achievement Name";

    /**
     * description
     *
     * @var string
     */
    public $description = "Achievement Description";

    /**
     * points
     *
     * @var int
     */
    public $points = 1;

    /**
     * type
     *
     * @var string
     */
    public $type;

    public function __construct()
    {

        if (empty($this->model)) {
            throw new Exception('you must set the model name');
        }

        if (empty($this->model)) {
            throw new Exception('you must set the model progress name');
        }
    }

    /**
     * model
     *
     * @return object
     */
    private function modelName()
    {
        return (new \ReflectionClass($this->model))->newInstance();
    }

    /**
     * Return class achievement name
     * @return void
     */
    private function getClassName()
    {
        return (new \ReflectionClass(get_called_class()))->getShortName();
    }

    /**
     * Create | Update achievements table based on achievement type who is using it,
     * then return achievement model.
     * @return object $model
     */
    public function getModel()
    {
        $model = $this->modelName()::where('class_name', $this->getClassName())->where('type', $this->type)->first();
        if (is_null($model)) {
            $model = new $this->model();
            $model->class_name = $this->getClassName();
        }

        // updates the model with data from the called achievements class
        $model->name        = $this->name;
        $model->description = $this->description;
        $model->points      = $this->points;
        $model->type        = $this->type;
        $model->save();
        return $model;
    }

    /**
     * Assign progress to achiever.
     *
     * @param  mixed $achiever
     * @param  mixed $points
     * @return void
     */
    public function addProgressToAchiever($achiever, $points = 1)
    {
        $progress = $this->getOrCreateProgressForAchiever($achiever);
        if ($progress->isLocked()) {
            if ($points >= $progress->{$this->modelProgressRelationNameWithModel}->points) {
                $progress->points = $progress->{$this->modelProgressRelationNameWithModel}->points;
            } elseif ($points < 0) {
                $progress->points = 0;
            } else {
                $progress->points += $points;
            }
            $progress->save();

            if ($progress->isUnLocked()) {
                $this->triggerUnlocked($achiever);
            }
        }
    }

    /**
     * Set progress point to achiever directly.
     *
     * @param  mixed $achiever
     * @param  mixed $points
     * @return void
     */
    public function setProgressToAchiever($achiever, $points)
    {
        $progress = $this->getOrCreateProgressForAchiever($achiever);
        if ($progress->isLocked()) {
            if ($points >= $progress->{$this->modelProgressRelationNameWithModel}->points) {
                $progress->points = $progress->{$this->modelProgressRelationNameWithModel}->points;
            } elseif ($points < 0) {
                $progress->points = 0;
            } else {
                $progress->points = $points;
            }
            $progress->save();
            if ($progress->isUnLocked()) {
                $this->triggerUnlocked($achiever);
            }
        }
    }

    /**
     * Create progrees for achiever or get created progress.
     * @param  mixed $achiever
     * @return object $modelProgress
     */
    public function getOrCreateProgressForAchiever($achiever)
    {
        $achievement = $this->getModel();
        $foreignKey = $achievement->getForeignKey();
        $progress = $this->modelProgress::where($foreignKey, $achievement->id)
            ->where('user_id', $achiever->id)
            ->first();

        if (is_null($progress)) {
            $progress = new $this->modelProgress;
            $progress->$foreignKey = $achievement->id;
            $progress->user_id = $achiever->id;
            $progress->save();
        }

        return $progress;
    }

    /**
     * Trigger event when unlocked achievement.
     * @return void
     */
    public abstract function triggerUnlocked($achiever);
}
