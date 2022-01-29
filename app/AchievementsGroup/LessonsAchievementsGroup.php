<?php

namespace App\AchievementsGroup;

use App\Contracts\AchievementsGroup;
use App\Achievements\Lessons\TenLessonsWatched;
use App\Achievements\Lessons\FirstLessonWatched;
use App\Achievements\Lessons\FiveLessonsWatched;
use App\Achievements\Lessons\FiftyLessonsWatched;
use App\Achievements\Lessons\TwentyFiveLessonsWatched;


class LessonsAchievementsGroup extends AchievementsGroup
{

    /**
     * Array of achivements.
     *
     * @return array
     */
    public  function group()
    {
        return [
            new FirstLessonWatched(),
            new FiveLessonsWatched(),
            new TenLessonsWatched(),
            new TwentyFiveLessonsWatched(),
            new FiftyLessonsWatched(),
        ];
    }
}
