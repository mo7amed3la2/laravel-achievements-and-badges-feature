<?php

namespace App\Achievements\Comments;

use App\Models\Achievement;
use App\Contracts\Achievements;
use App\Models\AchievementProgress;

class CommentWrittenAchievement extends Achievements
{
    public $modelClass = Achievement::class;
    
    public $modelProgressClass = AchievementProgress::class;

    public $type = Achievement::TYPE_COMMENT_WRITTEN;
}
