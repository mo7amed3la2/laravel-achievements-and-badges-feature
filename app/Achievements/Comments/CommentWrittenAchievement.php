<?php

namespace App\Achievements\Comments;

use App\Models\Achievement;
use App\Contracts\Achievements;
use App\Events\AchievementUnlocked;
use App\Models\AchievementProgress;

class CommentWrittenAchievement extends Achievements
{
    public $model = Achievement::class;

    public $modelProgress = AchievementProgress::class;

    public $type = Achievement::TYPE_COMMENT_WRITTEN;

    public function triggerUnlocked($achiever)
    {
        event(new AchievementUnlocked($this->name, $achiever));
    }
}
