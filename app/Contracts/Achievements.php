<?php

namespace App\Contracts;

use ReflectionClass;
use App\Models\Achievement;
use App\Events\BadgeUnlocked;
use App\Events\AchievementUnlocked;
use App\Models\AchievementProgress;


abstract class Achievements
{

    /**
     * modelClass
     *
     * @var mixed
     */
    public $modelClass;

    /**
     * modelProgressClass
     *
     * @var mixed
     */
    public $modelProgressClass;

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

    /**
     * modelClass
     *
     * @return object
     */
    private function modelClassName()
    {
        return (new \ReflectionClass($this->modelClass))->newInstance();
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
     * @return Achievement
     */
    public function getModel()
    {
        $model = $this->modelClassName()::where('class_name', $this->getClassName())->first();
        if (is_null($model)) {
            $model = new $this->modelClass();
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
     * @return AchievementProgress
     */
    public function getOrCreateProgressForAchiever($achiever)
    {
        $achievement = $this->getModel();
        $progress = $this->modelProgressClass::where('achievement_id', $achievement->id)
            ->where('user_id', $achiever->id)
            ->first();

        if (is_null($progress)) {
            $progress = new $this->modelProgressClass();
            $progress->achievement_id = $achievement->id;
            $progress->user_id = $achiever->id;
            $progress->save();
        }

        return $progress;
    }


    public function triggerUnlocked($achiever)
    {
        if ($this->type == Achievement::TYPE_BADGE) {
            event(new BadgeUnlocked($this->name, $achiever));
        } else {
            event(new AchievementUnlocked($this->name, $achiever));
        }
    }
}
