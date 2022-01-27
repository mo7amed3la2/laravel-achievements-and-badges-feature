<?php

namespace App\Listeners;

use App\Achievements\Badges\Master;
use App\Events\AchievementUnlocked;
use App\Achievements\Badges\Advanced;
use Illuminate\Queue\InteractsWithQueue;
use App\Achievements\Badges\Intermediate;
use Illuminate\Contracts\Queue\ShouldQueue;

class AchievementUnlockedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\AchievementUnlocked  $event
     * @return void
     */
    public function handle(AchievementUnlocked $event)
    {
        $user = $event->user;
        info('Hi '. $user->name . ' you have been unlocked achievement ' . $event->achievement_name);
        $user->addProgress(new Intermediate(), 1);
        $user->addProgress(new Advanced(), 1);
        $user->addProgress(new Master(), 1);
    }
}
