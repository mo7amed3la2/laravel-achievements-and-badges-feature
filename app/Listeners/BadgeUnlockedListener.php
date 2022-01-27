<?php

namespace App\Listeners;

use App\Events\BadgeUnlocked;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BadgeUnlockedListener
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
     * @param  \App\Events\BadgeUnlocked  $event
     * @return void
     */
    public function handle(BadgeUnlocked $event)
    {
        $user = $event->user;
        info('Hi '. $user->name . ' you have been unlocked badge ' . $event->achievement_name);
    }
}
