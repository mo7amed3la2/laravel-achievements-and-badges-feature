<?php

namespace App\Traits;

use App\Traits\EntityRelationsBadges;
use App\Traits\EntityRelationsAchievements;

trait Achiever
{
    use EntityRelationsAchievements, EntityRelationsBadges;
    
    /**
     * Adding achievement in progress.
     * @param $instance
     * @param $points
     * @return void
     */
    public function addProgress($instance, $points)
    {
        $instance->addProgressToAchiever($this, $points);
    }
    
    /**
     * Set progress poitns to achiever directly.
     *
     * @param $instance
     * @param $points
     * @return void
     */
    public function setProgress($instance, $points)
    {
        $instance->setProgressToAchiever($this, $points);
    }
    
    /**
     * Unlock achievements directly.
     * @param $instance
     * @return void
     */
    public function unlock($instance)
    {
        $this->setProgress($instance, $instance->points);
    }
}
