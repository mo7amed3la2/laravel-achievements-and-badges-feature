<?php

namespace App\Achievements\Lessons;

use App\Achievements\Lessons\LessonWatchedAchievement;

class FiveLessonsWatched extends LessonWatchedAchievement
{

    /**
     * name
     *
     * @var string
     */
    public $name = "5 Lesson Watched";

    /**
     * description
     *
     * @var string
     */
    public $description = "Achievement 5 Lessons Watched";

    /**
     * points
     *
     * @var int
     */
    public $points = 5;

}
