<?php

namespace App\Traits;

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
        return $this->achievements()->with('achievement')->whereNotNull('unlocked_at')->get()->pluck('achievement.name');
    }

    public function lockedAchievements()
    {
        return $this->achievements()->with('achievement')->whereNull('unlocked_at')->get()->pluck('achievement.name');
    }
}