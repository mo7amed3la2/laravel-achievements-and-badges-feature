<?php

namespace App\Achievements\Badges;

use App\Models\Achievement;
use App\Contracts\Achievements;
use App\Models\AchievementProgress;

class BadgesAchievement extends Achievements
{
    public $modelClass = Achievement::class;
    
    public $modelProgressClass = AchievementProgress::class;

    public $type = Achievement::TYPE_BADGE;
}
