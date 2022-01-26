<?php

namespace App\Achievements\Comments;

use App\Contracts\Achievements;

class TwentyCommentsWritten extends Achievements
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
