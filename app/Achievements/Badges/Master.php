<?php

namespace App\Achievements\Badges;

use App\Achievements\Badges\BadgesAchievement;

class Master extends BadgesAchievement
{

    /**
     * name
     *
     * @var string
     */
    public $name = "10 Achievements";

    /**
     * description
     *
     * @var string
     */
    public $description = "Master: 10 Achievements";

    /**
     * points
     *
     * @var int
     */
    public $points = 10;
}
