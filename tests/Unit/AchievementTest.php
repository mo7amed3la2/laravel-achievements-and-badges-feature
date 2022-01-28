<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use App\Achievements\Comments\FirstCommentWritten;
use App\Achievements\Comments\FiveCommentsWritten;
use App\Models\Achievement;
use App\Models\AchievementProgress;

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
}
