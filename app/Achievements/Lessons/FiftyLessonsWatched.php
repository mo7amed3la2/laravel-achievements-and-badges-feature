<?php

namespace App\Achievements;

use App\Contracts\Achievements;

class FiftyLessonsWatched extends Achievements
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
    public $points = 25;
}
