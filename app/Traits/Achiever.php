<?php

namespace App\Traits;

use App\Traits\EntityRelationsBadges;
use App\Traits\EntityRelationsAchievements;

trait Achiever
{
    use EntityRelationsAchievements, EntityRelationsBadges;
    
    /**
     * addProgress
     * adding achievement in progress.
     * @param  mixed $instance
     * @param  mixed $points
     * @return void
     */
    public function addProgress($instance, $points)
    {
        $instance->addProgressToAchiever($this, $points);
    }
    
    /**
     * Set progress poitns to achiever directly.
     *
     * @param  mixed $instance
     * @param  mixed $points
     * @return void
     */
    public function setProgress($instance, $points)
    {
        $instance->setProgressToAchiever($this, $points);
    }
    
    /**
     * unlock
     * unlock achievements directly.
     * @param  mixed $instance
     * @return void
     */
    public function unlock($instance)
    {
        $this->setProgress($instance, $instance->points);
    }
}
