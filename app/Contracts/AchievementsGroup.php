<?php

namespace App\Contracts;


abstract class AchievementsGroup
{

    /**
     * Array of achivements.
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
        foreach ($this->group() as $achivement) {
            if ($points >= $achivement->points) {
                $achiver->unlock($achivement);
            } else {
                // to handle the scenario achiver already add comments before achievement assigned.
                $achiver->setProgress($achivement, $points);
            }
        }
    }
}
