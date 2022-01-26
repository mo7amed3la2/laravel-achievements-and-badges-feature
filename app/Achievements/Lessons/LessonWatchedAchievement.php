<?php

namespace App\Achievements\Lessons;

use App\Contracts\Achievements;
use App\Models\Achievement;

class LessonWatchedAchievement extends Achievements
{
    public $type = Achievement::TYPE_LESSON_WATCHED;
}
