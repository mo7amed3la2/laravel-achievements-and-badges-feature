<?php

namespace App\Achievements\Comments;

use App\Achievements\Comments\CommentWrittenAchievement;

class ThreeCommentsWritten extends CommentWrittenAchievement
{
    
    /**
     * name
     *
     * @var string
     */
    public $name = "3 Comments Written";
    
    /**
     * description
     *
     * @var string
     */
    public $description = "Achievement 3 Comments Written";

    /**
     * points
     *
     * @var int
     */
    public $points = 3;

}
