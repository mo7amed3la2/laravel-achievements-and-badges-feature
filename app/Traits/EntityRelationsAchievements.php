<?php

namespace App\Traits;

use App\Models\AchievementProgress;

trait EntityRelationsAchievements
{
    public function achievements()
    {
        return $this->hasMany(AchievementProgress::class);
    }

    public function nextAvailableAchievements()
    {
        return $this->lastAchievements();
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
        return $this->achievements()->with('achievement')->whereNull('unlocked_at')->get();
    }

    public function lastAchievements()
    {
        $latest =  $this->achievements()->with('achievement')->latest()->first();
        $nextAchievement = $latest->achievement->nextAchievement;
        if($latest->isUnLocked() and $nextAchievement){
            return $nextAchievement['name'];
        }elseif($latest->isLocked()){
            return $latest->achievement->pluck('name');
        }
    }
}
