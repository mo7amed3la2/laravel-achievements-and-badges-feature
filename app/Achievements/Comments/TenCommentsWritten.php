<?php

namespace App\Achievements\Comments;

use App\Achievements\Comments\CommentWrittenAchievement;

class TenCommentsWritten extends CommentWrittenAchievement
{
    
    /**
     * name
     *
     * @var string
     */
    public $name = "10 Comment Written";
    
    /**
     * description
     *
     * @var string
     */
    public $description = "Achievement 10 Comment Written";

    /**
     * points
     *
     * @var int
     */
    public $points = 10;

}
