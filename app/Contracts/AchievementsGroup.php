<?php

namespace App\Contracts;


abstract class AchievementsGroup
{

    /**
     * Array of achievements.
     *
     * @return array
     */
    public abstract function group();
    
    /**
     * addGroupProgress
     *
     * @param $achiver
     * @param $points
     * @return void
     */
    public function addGroupProgress($achiver, $points)
    {
        foreach ($this->group() as $achievement) {
            if ($points >= $achievement->points) {
                $achiver->unlock($achievement);
            } else {
                // to handle the scenario achiver already add comments before achievement assigned.
                $achiver->setProgress($achievement, $points);
            }
        }
    }
}
