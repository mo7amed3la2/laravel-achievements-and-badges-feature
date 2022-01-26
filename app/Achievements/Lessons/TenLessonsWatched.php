<?php

namespace App\Achievements;

use App\Contracts\Achievements;
use App\Achievements\TwentyFiveLessonsWatched;

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
    public $points = 4;

    public  $next_achievement = TwentyFiveLessonsWatched::class;

}
