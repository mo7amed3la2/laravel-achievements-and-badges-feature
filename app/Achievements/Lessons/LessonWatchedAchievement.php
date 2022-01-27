<?php

namespace App\Achievements\Lessons;

use App\Models\Achievement;
use App\Contracts\Achievements;
use App\Models\AchievementProgress;

class LessonWatchedAchievement extends Achievements
{
    public $modelClass = Achievement::class;

    public $modelProgressClass = AchievementProgress::class;

    public $type = Achievement::TYPE_LESSON_WATCHED;
}
