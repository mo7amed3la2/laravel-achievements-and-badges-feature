<?php

namespace App\Achievements\Comments;

use App\Achievements\Comments\CommentWrittenAchievement;

class FiveCommentsWritten extends CommentWrittenAchievement
{
    
    /**
     * name
     *
     * @var string
     */
    public $name = "5 Comments Written";
    
    /**
     * description
     *
     * @var string
     */
    public $description = "Achievement 5 Comments Written";

    /**
     * points
     *
     * @var int
     */
    public $points = 5;

}
