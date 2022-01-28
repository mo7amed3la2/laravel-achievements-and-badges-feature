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
        $countUserLessonWatched = $user->watched->count();

        $achivements = [
            new FirstLessonWatched(),
            new FiveLessonsWatched(),
            new TenLessonsWatched(),
            new TwentyFiveLessonsWatched(),
            new FiftyLessonsWatched(),
        ];
        
        foreach ($achivements as $achivement) {
            if ($countUserLessonWatched >= $achivement->points) {
                $user->unlock($achivement);
            } else {
                // to handle the scenario user already add comments before achievement assigned.
                $user->setProgress($achivement, $countUserLessonWatched);
            }
        }
    }
}
