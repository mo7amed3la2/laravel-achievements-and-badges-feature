<?php

namespace App\Contracts;

use App\Models\Achievement;
use App\Events\BadgeUnlocked;
use App\Events\AchievementUnlocked;
use App\Models\AchievementProgress;


abstract class Achievements
{

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
     * next_achievement
     *
     * @var null
     */
    public $next_achievement = null;

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
        $model = Achievement::where('class_name', $this->getClassName())->first();
        if (is_null($model)) {
            $model = new Achievement();
            $model->class_name = $this->getClassName();
        }

        // handle adding next achievement.
        $hasNextAchievement = false;
        if ($this->next_achievement != null) {
            $hasNextAchievement = true;
            $achievement = new $this->next_achievement;
            $nextAchievement = $achievement->getModel();
        }

        // updates the model with data from the called achievement class
        $model->name        = $this->name;
        $model->description = $this->description;
        $model->points      = $this->points;
        $model->type        = $this->type;
        // if ($hasNextAchievement) {
        //     $model->next_achievement_id = $nextAchievement->id;
        // }
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
        $progress = AchievementProgress::where('achievement_id', $achievement->id)
            ->where('user_id', $achiever->id)
            ->first();

        if (is_null($progress)) {
            $progress = new AchievementProgress();
            $progress->achievement_id = $achievement->id;
            $progress->user_id = $achiever->id;
            $progress->save();
        }

        return $progress;
    }


    public function triggerUnlocked($achiever)
    {
        if($this->type == Achievement::TYPE_BADGE){
            event(new BadgeUnlocked($this->name, $achiever));
        }else{
            event(new AchievementUnlocked($this->name, $achiever));
        }
    }
}
