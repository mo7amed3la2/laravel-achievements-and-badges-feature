<?php

namespace App\Listeners;

use App\Events\LessonWatched;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\AchievementsGroup\LessonsAchievementsGroup;

class LessonsWatchedAchievements
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
     * @param  \App\Events\LessonWatched  $event
     * @return void
     */
    public function handle(LessonWatched $event)
    {
        $user = $event->user;
        $countUserLessonWatched = $user->watched->count();

        // adding progress point to user.
        (new LessonsAchievementsGroup)->addGroupProgress($user, $countUserLessonWatched);
    }
}
