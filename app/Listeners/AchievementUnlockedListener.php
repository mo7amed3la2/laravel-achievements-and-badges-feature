<?php

namespace App\Listeners;

use App\Badges\Master;
use App\Badges\Advanced;
use App\Badges\Intermediate;
use App\Events\AchievementUnlocked;
use Illuminate\Queue\InteractsWithQueue;
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
