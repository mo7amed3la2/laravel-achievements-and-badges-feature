<?php

namespace App\Badges;

use App\Models\Badge;
use App\Events\BadgeUnlocked;
use App\Models\BadgeProgress;
use App\Contracts\Achievements;

class BadgesAchievement extends Achievements
{
    public $model = Badge::class;

    public $modelProgress = BadgeProgress::class;

    public $modelProgressRelationNameWithModel = 'badge';

    public $type = Badge::TYPE_BADGE;

    public function triggerUnlocked($achiever)
    {
        event(new BadgeUnlocked($this->name, $achiever));
    }
}
