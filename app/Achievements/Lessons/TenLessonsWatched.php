<?php

namespace App\Achievements\Lessons;

use App\Contracts\Achievements;

class TenLessonsWatched extends Achievements
{

    /**
     * name
     *
     * @var string
     */
    public $name = "10 Lesson Watched";

    /**
     * description
     *
     * @var string
     */
    public $description = "Achievement 10 Lessons Watched";

    /**
     * points
     *
     * @var int
     */
    public $points = 10;

}
