<?php

namespace App\Traits;

use App\Traits\EntityRelationsAchievements;

trait Achiever
{
    use EntityRelationsAchievements;

    public function addProgress($instance, $points)
    {
        $instance->addProgressToAchiever($this, $points);
    }

    public function unlock($instance)
    {
        $this->addProgress($instance, $instance->points);
    }
}
