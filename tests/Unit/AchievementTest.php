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

        // unlock another achievement.
        $this->user->unlock($this->fiveCommentsWritten);
        $this->user = $this->user->fresh();

        // check user has one unlocked achievement.
        $this->assertEquals(2, $this->user->unlockedAchievements()->count());
    }
}
