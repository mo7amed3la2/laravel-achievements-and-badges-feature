<?php

namespace Tests\Unit;

use Tests\TestCase;

class AchievementTest extends TestCase
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
    public function test_unlocked()
    {
        // unlock first achievement.
        $this->user->unlock($this->firstCommentWritten);
        $this->user = $this->user->fresh();

        // check user has one unlocked achievement.
        $this->assertCount(1, $this->user->unlockedAchievements());

        // check the first unlocked achievement get same data.
        $this->assertEquals($this->firstCommentWritten->name, $this->user->unlockedAchievements()->first()->achievement->name);

        // unlock another achievement.
        $this->user->unlock($this->fiveCommentsWritten);
        $this->user = $this->user->fresh();

        // check user has one unlocked achievement.
        $this->assertCount(2, $this->user->unlockedAchievements());

        // check the second unlocked achievement get the same data.
        $this->assertEquals($this->fiveCommentsWritten->name, $this->user->unlockedAchievements()[1]->achievement->name);
    }

    /**
     * Test in progress achievement.
     *
     * @return void
     */
    public function test_add_progress()
    {
        // adding in progress the first achievement.
        $this->user->addProgress($this->fiveCommentsWritten, 1);
        $this->user = $this->user->fresh();

        // check user does not have unlocked achievements.
        $this->assertCount(0, $this->user->unlockedAchievements());

        // check user has one achievement in progress.
        $this->assertCount(1, $this->user->inProgressAchievements());

        // check in progress achievement get the same data.
        $this->assertEquals($this->fiveCommentsWritten->name, $this->user->inProgressAchievements()->first()->achievement->name);
    }

    /**
     * Test in progress achievement has expected points.
     * @depends test_add_progress
     * @return void
     */
    public function test_add_progress_achievement_has_expected_points()
    {
        // adding in progress the first achievement.
        $this->user->addProgress($this->fiveCommentsWritten, 1);
        $this->user = $this->user->fresh();

        // check user has one achievement in progress.
        $this->assertEquals(1, $this->user->inProgressAchievements()->first()->points);

        // adding another point in progress the first achievement.
        $this->user->addProgress($this->fiveCommentsWritten, 1);
        $this->user = $this->user->fresh();

        // check user has one achievement in progress with expected pooints.
        $this->assertEquals(2, $this->user->inProgressAchievements()->first()->points);
    }

    /**
     * Test in progress for achievement that unlocked from first time.
     *
     * @return void
     */
    public function test_add_progress_for_achievement_that_unlocked_from_first_time()
    {
        // adding in progress the first achievement.
        $this->user->addProgress($this->firstCommentWritten, 1);
        $this->user = $this->user->fresh();

        // check user has unlocked achievements.
        $this->assertCount(1, $this->user->unlockedAchievements());

        // check user does not have achievement in progress.
        $this->assertCount(0, $this->user->inProgressAchievements());
    }

    /**
     * Test add progress for adding points greater than achievement points.
     *
     * @return void
     */
    public function test_add_progress_for_adding_points_greater_than_achievement_points()
    {
        // adding add progress 4 point for first achievement.
        $this->user->addProgress($this->fiveCommentsWritten, 10);
        $this->user = $this->user->fresh();

        // check user does not have unlocked achievements.
        $this->assertCount(1, $this->user->unlockedAchievements());

        // check user has one achievement in progress.
        $this->assertCount(0, $this->user->inProgressAchievements());

        // check user has one achievement unlocked with expected pooints.
        $this->assertEquals(5, $this->user->unlockedAchievements()->first()->points);
    }

    /**
     * Test add progress for adding points less than zreo.
     *
     * @return void
     */
    public function test_add_progress_for_adding_points_less_than_zero()
    {
        // adding add progress 4 point for first achievement.
        $this->user->addProgress($this->fiveCommentsWritten, -10);
        $this->user = $this->user->fresh();

        // check user does not have unlocked achievements.
        $this->assertCount(0, $this->user->unlockedAchievements());

        // check user has one achievement in progress.
        $this->assertCount(0, $this->user->inProgressAchievements());
    }

    /**
     * Test set progress achievement.
     *
     * @return void
     */
    public function test_set_progress()
    {
        // adding set progress 4 point for first achievement.
        $this->user->setProgress($this->fiveCommentsWritten, 4);
        $this->user = $this->user->fresh();

        // check user does not have unlocked achievements.
        $this->assertCount(0, $this->user->unlockedAchievements());

        // check user has one achievement in progress.
        $this->assertCount(1, $this->user->inProgressAchievements());

        // check user has one achievement in progress with expected pooints.
        $this->assertEquals(4, $this->user->inProgressAchievements()->first()->points);

        // adding set progress 1 point for first achievement.
        $this->user->setProgress($this->fiveCommentsWritten, 1);
        $this->user = $this->user->fresh();

        // check user has one achievement in progress with expected pooints.
        $this->assertEquals(1, $this->user->inProgressAchievements()->first()->points);

        // check in progress achievement get the same data.
        $this->assertEquals($this->fiveCommentsWritten->name, $this->user->inProgressAchievements()->first()->achievement->name);
    }

    /**
     * Test set progress for adding points greater than achievement points.
     *
     * @return void
     */
    public function test_set_progress_for_adding_points_greater_than_achievement_points()
    {
        // adding set progress 4 point for first achievement.
        $this->user->setProgress($this->fiveCommentsWritten, 10);
        $this->user = $this->user->fresh();

        // check user does not have unlocked achievements.
        $this->assertCount(1, $this->user->unlockedAchievements());

        // check user has one achievement in progress.
        $this->assertCount(0, $this->user->inProgressAchievements());

        // check user has one achievement unlocked with expected pooints.
        $this->assertEquals(5, $this->user->unlockedAchievements()->first()->points);
    }

    /**
     * Test set progress for adding points less than zreo.
     *
     * @return void
     */
    public function test_set_progress_for_adding_points_less_than_zero()
    {
        // adding set progress 4 point for first achievement.
        $this->user->setProgress($this->fiveCommentsWritten, -10);
        $this->user = $this->user->fresh();

        // check user does not have unlocked achievements.
        $this->assertCount(0, $this->user->unlockedAchievements());

        // check user has one achievement in progress.
        $this->assertCount(0, $this->user->inProgressAchievements());
    }
}
