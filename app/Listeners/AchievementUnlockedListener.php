<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\AchievementsGroup\BadgesAchievementsGroup;

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
        $countUserAchievements = $user->unlockedAchievements()->count();

        info('Hi ' . $user->name . ' you have been unlocked achievement ' . $event->achievement_name);

        // adding progress point to user.   
        (new BadgesAchievementsGroup)->addGroupProgress($user, $countUserAchievements);
    }
}
