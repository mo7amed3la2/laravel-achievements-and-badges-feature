<?php

namespace App\Achievements\Comments;

use App\Contracts\Achievements;

class FirstCommentWritten extends Achievements
{
    
    /**
     * name
     *
     * @var string
     */
    public $name = "First Comment Written";
    
    /**
     * description
     *
     * @var string
     */
    public $description = "Achievement First Comment Written";

}
