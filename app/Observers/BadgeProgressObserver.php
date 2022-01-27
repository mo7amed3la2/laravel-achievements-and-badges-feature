<?php

namespace App\Observers;

use Carbon\Carbon;
use App\Models\BadgeProgress;

class BadgeProgressObserver
{
    /**
     * Handle the BadgeProgress "created" event.
     *
     * @param  \App\Models\BadgeProgress  $badgeProgress
     * @return void
     */
    public function created(BadgeProgress $badgeProgress)
    {
        //
    }

    /**
     * Handle the AchievementProgress "updating" event.
     *
     * @param  \App\Models\BadgeProgress  $badgeProgress
     * @return void
     */
    public function updating(BadgeProgress $badgeProgress)
    {
        if (is_null($badgeProgress->unlockedAt) && !$badgeProgress->isLocked()) {
            $badgeProgress->unlocked_at = Carbon::now();
        }
    }

    /**
     * Handle the BadgeProgress "updated" event.
     *
     * @param  \App\Models\BadgeProgress  $badgeProgress
     * @return void
     */
    public function updated(BadgeProgress $badgeProgress)
    {
        //
    }

    /**
     * Handle the BadgeProgress "deleted" event.
     *
     * @param  \App\Models\BadgeProgress  $badgeProgress
     * @return void
     */
    public function deleted(BadgeProgress $badgeProgress)
    {
        //
    }

    /**
     * Handle the BadgeProgress "restored" event.
     *
     * @param  \App\Models\BadgeProgress  $badgeProgress
     * @return void
     */
    public function restored(BadgeProgress $badgeProgress)
    {
        //
    }

    /**
     * Handle the BadgeProgress "force deleted" event.
     *
     * @param  \App\Models\BadgeProgress  $badgeProgress
     * @return void
     */
    public function forceDeleted(BadgeProgress $badgeProgress)
    {
        //
    }
}
