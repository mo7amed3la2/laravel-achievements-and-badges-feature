<?php

namespace App\Badges;

use App\Badges\Master;
use App\Badges\Advanced;
use App\Badges\Intermediate;
use App\Contracts\AchievementsGroup;


class BadgesAchievementsGroup extends AchievementsGroup
{

    /**
     * Array of achivements.
     *
     * @return array
     */
    public  function group()
    {
        return [
            new Intermediate(),
            new Advanced(),
            new Master(),
        ];
    }
}