<?php

namespace App\Traits;

use App\Models\Achievement;
use App\Models\AchievementProgress;

trait EntityRelationsAchievements
{
    public function achievements()
    {
        return $this->hasMany(AchievementProgress::class);
    }

    public function inProgressAchievements()
    {
        return $this->achievements()->whereNull('unlocked_at')->where('points', '>', 0)->get();
    }

    public function unlockedAchievements()
    {
        return $this->achievements()->with('achievement')->whereNotNull('unlocked_at')->get();
    }

    public function lockedAchievements()
    {
        return $this->achievements()->with('achievement')->whereNull('unlocked_at')->get();
    }


    public function listUnlockedAchievements()
    {
        return $this->unlockedAchievements()->pluck('achievement.name');
    }

    public function nextAvailableAchievements()
    {
        $nextCommentsWrittenAchievement = AchievementProgress::whereHas('achievement', function ($q) {
            $q->where('type', Achievement::TYPE_COMMENT_WRITTEN);
        })->whereNull('unlocked_at')->first()->achievement->name;

        $nextLessonWatchedAchievement = AchievementProgress::whereHas('achievement', function ($q) {
            $q->where('type', Achievement::TYPE_LESSON_WATCHED);
        })->whereNull('unlocked_at')->first()->achievement->name;

        return [
            $nextCommentsWrittenAchievement,
            $nextLessonWatchedAchievement
        ];
    }
}
