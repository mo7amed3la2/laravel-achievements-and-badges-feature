<?php

namespace App\AchievementsGroup;

use App\Contracts\AchievementsGroup;
use App\Achievements\Comments\TenCommentsWritten;
use App\Achievements\Comments\FirstCommentWritten;
use App\Achievements\Comments\FiveCommentsWritten;
use App\Achievements\Comments\ThreeCommentsWritten;
use App\Achievements\Comments\TwentyCommentsWritten;


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
            new TenCommentsWritten(),
            new TwentyCommentsWritten(),
        ];
    }
}
