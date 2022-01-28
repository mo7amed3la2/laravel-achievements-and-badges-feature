<?php

namespace App\Traits;

use App\Models\Badge;
use App\Badges\Beginner;
use App\Models\BadgeProgress;

trait EntityRelationsBadges
{
    public function badges()
    {
        return $this->hasMany(BadgeProgress::class);
    }

    /**
     * In progress badges.
     */
    public function inProgressBadges()
    {
        return $this->badges()->whereNull('unlocked_at')->where('points', '>', 0)->get();
    }

    /**
     * Unlocked badges.
     */
    public function unlockedBadges()
    {
        return $this->badges()->with('badge')->whereNotNull('unlocked_at')->orderBy('points', 'ASC')->get();
    }

    /**
     * Locked badges.
     */
    public function lockedBadges()
    {
        return $this->badges()->with('badge')->whereNull('unlocked_at')->get();
    }

    /**
     * List unlocked badges.
     */
    public function listUnlockedBadges()
    {
        return $this->unlockedBadges()->pluck('badge.name');
    }

    /**
     * Current badge
     */
    public function currentBadge()
    {
        $currentBadge = $this->badges()->whereNotNull('unlocked_at')->where('points', '>', 0)->orderBy('id', 'DESC')->get()->first();
        if ($currentBadge) {
            return $currentBadge->badge->description;
        }
        return (new Beginner)->description;
    }

    /**
     * Next available badge
     *
     * @return string
     */
    public function nextAvailableBadge()
    {
        $nextAvailableBadge = BadgeProgress::whereHas('badge', function ($q) {
            $q->where('type', Badge::TYPE_BADGE);
        })->whereNull('unlocked_at')->first();

        if ($nextAvailableBadge) {
            return $nextAvailableBadge->badge->description;
        }
        return '';
    }

    /**
     * Remaing to unlock next badge.
     * @return integer
     */
    public function remaingToUnlockNextBadge()
    {
        $nextAvailableBadge = BadgeProgress::whereHas('badge', function ($q) {
            $q->where('type', Badge::TYPE_BADGE);
        })->whereNull('unlocked_at')->first();

        if ($nextAvailableBadge) {
            $badgePoints = $nextAvailableBadge->badge->points;
            return $badgePoints - $nextAvailableBadge->points;
        }
        return 0;
    }
}
