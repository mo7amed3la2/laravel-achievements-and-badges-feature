<?php

namespace App\Achievements\Lessons;

use App\Achievements\Lessons\LessonWatchedAchievement;

class FiftyLessonsWatched extends LessonWatchedAchievement
{

    /**
     * name
     *
     * @var string
     */
    public $name = "50 Lesson Watched";

    /**
     * description
     *
     * @var string
     */
    public $description = "Achievement 50 Lessons Watched";

    /**
     * points
     *
     * @var int
     */
    public $points = 50;
}
