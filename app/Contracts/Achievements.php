<?php

namespace App\Contracts;

use Exception;
use App\Models\Achievement;
use App\Models\AchievementProgress;


abstract class Achievements
{

    /**
     * model
     *
     * @var mixed
     */
    public $model;

    /**
     * modelProgress
     *
     * @var mixed
     */
    public $modelProgress;

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
     * tpye
     *
     * @var undefined
     */
    public $tpye = null;

    public function __construct()
    {

        if (empty($this->model)) {
            throw new Exception('you must set model name');
        }

        if (empty($this->model)) {
            throw new Exception('you must set model progress name');
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
        $model = $this->modelName()::where('class_name', $this->getClassName())->first();
        if (is_null($model)) {
            $model = new $this->model();
            $model->class_name = $this->getClassName();
        }
        // updates the model with data from the called achievement class
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
            $progress->points += $points;
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
            $progress = new $this->modelProgress();
            $progress->$foreignKey = $achievement->id;
            $progress->user_id = $achiever->id;
            $progress->save();
        }

        return $progress;
    }


    /**
     * triggerUnlocked
     * trigger event when unlocked achievement.
     * @return void
     */
    public abstract function triggerUnlocked($achiever);
}
