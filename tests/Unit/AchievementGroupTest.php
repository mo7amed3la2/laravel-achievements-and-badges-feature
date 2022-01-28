<?php

namespace Tests\Unit;

use Tests\TestCase;
use Tests\Achievements\CommentsAchievementsGroup;

class AchievementGroupTest extends TestCase
{

    /**
     * Tests the setup
     */
    public function testSetup()
    {
        // check user does not have achievements.
        $this->assertEquals(0, $this->user->achievements->count());
    }

    /**
     * Test unlocked achievement.
     *
     * @return void
     */
    public function test_unlocked_achievements_group()
    {

        $points = 1;

        (new CommentsAchievementsGroup)->addGroupProgress($this->user, $points);

        $this->user = $this->user->fresh();

        // check user has one unlocked achievement.
        $this->assertCount(1, $this->user->unlockedAchievements());

        // check the first unlocked achievement get same data.
        $this->assertEquals($this->firstCommentWritten->name, $this->user->unlockedAchievements()->first()->achievement->name);

        // check user has one unlocked achievement.
        $this->assertCount(1, $this->user->unlockedAchievements());

        // check the second unlocked achievement get the same data.
        $this->assertEquals($this->threeCommentsWritten->name, $this->user->lockedAchievements()[0]->achievement->name);

        // check the third unlocked achievement get the same data.
        $this->assertEquals($this->fiveCommentsWritten->name, $this->user->lockedAchievements()[1]->achievement->name);
    }
}
