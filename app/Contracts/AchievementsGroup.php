<?php

namespace App\Contracts;


abstract class AchievementsGroup
{

    /**
     * Array of achievments.
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
        foreach ($this->group() as $achievment) {
            if ($points >= $achievment->points) {
                $achiver->unlock($achievment);
            } else {
                // to handle the scenario achiver already add comments before achievement assigned.
                $achiver->setProgress($achievment, $points);
            }
        }
    }
}
