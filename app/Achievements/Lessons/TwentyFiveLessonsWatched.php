<?php

namespace App\Achievements\Lessons;

use App\Contracts\Achievements;

class TwentyFiveLessonsWatched extends Achievements
{

    /**
     * name
     *
     * @var string
     */
    public $name = "25 Lesson Watched";

    /**
     * description
     *
     * @var string
     */
    public $description = "Achievement 25 Lessons Watched";

    /**
     * points
     *
     * @var int
     */
    public $points = 25;

}
