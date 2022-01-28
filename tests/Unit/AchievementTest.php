<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use App\Achievements\Comments\FirstCommentWritten;
use App\Achievements\Comments\FiveCommentsWritten;

class AchievementTest extends TestCase
{
    public $users;
    public $firstCommentWritten;
    public $fiveCommentsWritten;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:fresh');
        Artisan::call('migrate');
        $this->user = User::factory()->create();

        $this->firstCommentWritten = new FirstCommentWritten();
        $this->fiveCommentsWritten = new FiveCommentsWritten();
    }

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
    public function test_in_progress()
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
     * Test in progress achievement.
     * @depends test_in_progress
     * @return void
     */
    public function test_in_progress_achievement_has_expected_points()
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
     * Test in progress for unlocked achievement.
     *
     * @return void
     */
    public function test_in_progress_for_achievement_that_unlocked_from_first_time()
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
}
