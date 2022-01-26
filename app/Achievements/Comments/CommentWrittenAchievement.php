<?php

namespace App\Achievements\Comments;

use App\Contracts\Achievements;
use App\Models\Achievement;

class CommentWrittenAchievement extends Achievements
{
    public $type = Achievement::TYPE_COMMENT_WRITTEN;
}
