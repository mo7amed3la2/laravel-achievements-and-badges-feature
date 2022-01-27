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
     * unlock
     * unlock achievements directly.
     * @param  mixed $instance
     * @return void
     */
    public function unlock($instance)
    {
        $this->addProgress($instance, $instance->points);
    }
}
