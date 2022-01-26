<?php

namespace App\Traits;

trait Achiever
{

    public function addProgress($instance, $points)
    {
        $instance->addProgressToAchiever($this, $points);
    }

    public function unlock($instance)
    {
        $this->addProgress($instance, $instance->points);
    }
}
