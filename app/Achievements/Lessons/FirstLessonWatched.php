<?php

namespace App\Achievements;

use App\Contracts\Achievements;
use App\Achievements\FiveLessonWatched;
use App\Achievements\TenLessonsWatched;

class FirstLessonWatched extends Achievements
{
    
    /**
     * name
     *
     * @var string
     */
    public $name = "First Lesson Watched";
    
    /**
     * description
     *
     * @var string
     */
    public $description = "Achievement First Lesson Watched";
    
    /**
     * next_achievement
     *
     * @var undefined
     */
    public  $next_achievement = TenLessonsWatched::class;
}
