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

    /**
     * In progress achievements.
     */
    public function inProgressAchievements()
    {
        return $this->achievements()->whereNull('unlocked_at')->where('points', '>', 0)->get();
    }

    /**
     * Unlocked achievements.
     */
    public function unlockedAchievements()
    {
        return $this->achievements()->with('achievement')->whereNotNull('unlocked_at')->orderBy('points', 'ASC')->get();
    }

    /**
     * Locked achievements.
     */
    public function lockedAchievements()
    {
        return $this->achievements()->with('achievement')->whereNull('unlocked_at')->get();
    }


    /**
     * List unlocked achievements.
     */
    public function listUnlockedAchievements()
    {
        return $this->unlockedAchievements()->pluck('achievement.name');
    }

    /**
     * List next available achievements.
     *
     * @return array
     */
    public function nextAvailableAchievements()
    {
        $data = [];

        $achievementTypes = Achievement::select('type')->groupBy('type')->get()->pluck('type');

        foreach ($achievementTypes as $type) {
            $achievement = AchievementProgress::whereHas('achievement', function ($q) use ($type) {
                $q->where('type', $type);
            })->whereNull('unlocked_at')->orderBy('points', 'ASC')->first();

            if ($achievement) {
                $data[] = $achievement->achievement->name;
            }
        }

        return $data;
    }
}
