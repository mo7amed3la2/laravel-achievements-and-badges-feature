<?php

namespace App\Achievements\Comments;

use App\Contracts\Achievements;

class FiveCommentsWritten extends Achievements
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
