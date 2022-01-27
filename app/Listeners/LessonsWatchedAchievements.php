<?php

namespace App\Listeners;

use App\Events\LessonWatched;
use App\Achievements\Lessons\TenLessonsWatched;
use App\Achievements\Lessons\FirstLessonWatched;
use App\Achievements\Lessons\FiveLessonsWatched;
use Illuminate\Queue\InteractsWithQueue;
use App\Achievements\Lessons\FiftyLessonsWatched;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Achievements\Lessons\TwentyFiveLessonsWatched;

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
        $user->unlock(new FirstLessonWatched());
        $user->addProgress(new FiveLessonsWatched(), 1);
        // $user->addProgress(new TenLessonsWatched(), 1);
        // $user->addProgress(new TwentyFiveLessonsWatched(), 1);
        // $user->addProgress(new FiftyLessonsWatched(), 1);
    }
}
