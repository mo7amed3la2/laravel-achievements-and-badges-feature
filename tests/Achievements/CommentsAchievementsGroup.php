<?php

namespace Tests\Achievements;

use App\Contracts\AchievementsGroup;
use App\Achievements\Comments\FirstCommentWritten;
use App\Achievements\Comments\FiveCommentsWritten;
use App\Achievements\Comments\ThreeCommentsWritten;


class CommentsAchievementsGroup extends AchievementsGroup
{

    /**
     * Array of achivements.
     *
     * @return array
     */
    public  function group()
    {
        return [
            new FirstCommentWritten(),
            new ThreeCommentsWritten(),
            new FiveCommentsWritten(),
        ];
    }
}
