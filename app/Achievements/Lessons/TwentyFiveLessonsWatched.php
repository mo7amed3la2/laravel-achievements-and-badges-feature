<?php

namespace App\Achievements;

use App\Contracts\Achievements;
use App\Achievements\FiftyLessonsWatched;

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
    public $points = 15;

    public  $next_achievement = FiftyLessonsWatched::class;

}
