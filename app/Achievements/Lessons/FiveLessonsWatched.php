<?php

namespace App\Achievements;

use App\Contracts\Achievements;

class FiveLessonsWatched extends Achievements
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
    public $points = 4;

    public  $next_achievement = FiveLessonWatched::class;

}
