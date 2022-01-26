<?php

namespace App\Achievements\Comments;

use App\Achievements\Comments\CommentWrittenAchievement;

class TwentyCommentsWritten extends CommentWrittenAchievement
{
    
    /**
     * name
     *
     * @var string
     */
    public $name = "20 Comment Written";
    
    /**
     * description
     *
     * @var string
     */
    public $description = "Achievement 20 Comment Written";

    /**
     * points
     *
     * @var int
     */
    public $points = 20;

}
