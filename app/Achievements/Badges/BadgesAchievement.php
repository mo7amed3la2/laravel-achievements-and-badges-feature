<?php

namespace App\Achievements\Badges;

use App\Contracts\Achievements;
use App\Models\Achievement;

class BadgesAchievement extends Achievements
{
    public $type = Achievement::TYPE_BADGE;
}
