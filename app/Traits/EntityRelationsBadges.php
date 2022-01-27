<?php

namespace App\Traits;

use App\Models\Badge;
use App\Badges\Beginner;
use App\Models\Achievement;
use App\Badges\Intermediate;
use App\Models\BadgeProgress;
use App\Models\AchievementProgress;

trait EntityRelationsBadges
{
    public function badges()
    {
        return $this->hasMany(BadgeProgress::class);
    }

    public function inProgressBadges()
    {
        return $this->badges()->whereNull('unlocked_at')->where('points', '>', 0)->get();
    }

    public function unlockedBadges()
    {
        return $this->badges()->with('badge')->whereNotNull('unlocked_at')->get();
    }

    public function lockedBadges()
    {
        return $this->badges()->with('badge')->whereNull('unlocked_at')->get();
    }

    public function listUnlockedBadges()
    {
        return $this->unlockedBadges()->pluck('badge.name');
    }

    public function currentBadge()
    {
        $currentBadge = $this->badges()->whereNotNull('unlocked_at')->where('points', '>', 0)->orderBy('id','DESC')->get()->first();
        if ($currentBadge) {
            return $currentBadge->badge->description;
        }
        return (new Beginner)->description;
    }

    public function nextAvailableBadge()
    {
        $nextAvailableBadge = BadgeProgress::whereHas('badge', function ($q) {
            $q->where('type', Badge::TYPE_BADGE);
        })->whereNull('unlocked_at')->first();

        if ($nextAvailableBadge) {
            return $nextAvailableBadge->badge->description;
        }
        return (new Intermediate)->description;
    }

    public function remaingToUnlockNextBadge()
    {
        $nextAvailableBadge = BadgeProgress::whereHas('badge', function ($q) {
            $q->where('type', Badge::TYPE_BADGE);
        })->whereNull('unlocked_at')->first();

        if ($nextAvailableBadge) {
            $badgePoints = $nextAvailableBadge->badge->points;
            return $badgePoints - $nextAvailableBadge->points ;
        }
        return 0;
    }
}
