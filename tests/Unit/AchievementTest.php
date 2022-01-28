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
     * Test unlocked achievement.
     *
     * @return void
     */
    public function test_unlocked()
    {
        // check user does not have achievements.
        $this->assertEquals(0, $this->user->achievements->count());

        // unlock first achievement.
        $this->user->unlock($this->firstCommentWritten);
        $this->user = $this->user->fresh();

        // check user has one unlocked achievement.
        $this->assertEquals(1, $this->user->unlockedAchievements()->count());

        // check the first unlocked achievement get same data.
        $this->assertEquals($this->firstCommentWritten->name, $this->user->unlockedAchievements()->first()->achievement->name);

        // unlock another achievement.
        $this->user->unlock($this->fiveCommentsWritten);
        $this->user = $this->user->fresh();

        // check user has one unlocked achievement.
        $this->assertEquals(2, $this->user->unlockedAchievements()->count());

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
        // check user does not have achievements.
        $this->assertEquals(0, $this->user->achievements->count());

        // adding in progress the first achievement.
        $this->user->addProgress($this->fiveCommentsWritten, 1);
        $this->user = $this->user->fresh();

        // check user does not have unlocked achievements.
        $this->assertEquals(0, $this->user->unlockedAchievements()->count());

        // check user has one achievement in progress.
        $this->assertEquals(1, $this->user->inProgressAchievements()->count());

        // check in progress achievement get the same data.
        $this->assertEquals($this->fiveCommentsWritten->name, $this->user->inProgressAchievements()->first()->achievement->name);
    }
}
