<?php

namespace App\Observers;

use Carbon\Carbon;
use App\Models\AchievementProgress;

class AchievementProgressObserver
{
    /**
     * Handle the AchievementProgress "created" event.
     *
     * @param  \App\Models\AchievementProgress  $achievementProgress
     * @return void
     */
    public function created(AchievementProgress $achievementProgress)
    {
        //
    }

    /**
     * Handle the AchievementProgress "updating" event.
     *
     * @param  \App\Models\AchievementProgress  $achievementProgress
     * @return void
     */
    public function updating(AchievementProgress $achievementProgress)
    {
        if (is_null($achievementProgress->unlockedAt) && $achievementProgress->isLocked()) {
            $achievementProgress->unlocked_at = Carbon::now();
        }
    }

    /**
     * Handle the AchievementProgress "updated" event.
     *
     * @param  \App\Models\AchievementProgress  $achievementProgress
     * @return void
     */
    public function updated(AchievementProgress $achievementProgress)
    {
        //
    }

    /**
     * Handle the AchievementProgress "deleted" event.
     *
     * @param  \App\Models\AchievementProgress  $achievementProgress
     * @return void
     */
    public function deleted(AchievementProgress $achievementProgress)
    {
        //
    }

    /**
     * Handle the AchievementProgress "restored" event.
     *
     * @param  \App\Models\AchievementProgress  $achievementProgress
     * @return void
     */
    public function restored(AchievementProgress $achievementProgress)
    {
        //
    }

    /**
     * Handle the AchievementProgress "force deleted" event.
     *
     * @param  \App\Models\AchievementProgress  $achievementProgress
     * @return void
     */
    public function forceDeleted(AchievementProgress $achievementProgress)
    {
        //
    }
}
