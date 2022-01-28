<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Badges\Beginner;
use App\Badges\Intermediate;
use App\Achievements\Lessons\FirstLessonWatched;
use App\Achievements\Lessons\FiveLessonsWatched;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserAchievementsTest extends TestCase
{
    use DatabaseTransactions;

    public $firstBadge;
    public $secondBadge;

    public $firstLessonWatched;
    public $fiveLessonsWatched;

    public $response;

    public function setUp(): void
    {
        parent::setUp();

        $this->firstBadge = new Beginner();
        $this->secondBadge = new Intermediate();

        $this->firstLessonWatched = new FirstLessonWatched;
        $this->fiveLessonsWatched = new FiveLessonsWatched;
    }

    /**
     * Test user achievement endpoint work.
     *
     * @return void
     */
    public function test_user_achievement_endpoint_work()
    {
        $response = $this->get("/users/{$this->user->id}/achievements");
        $response->assertStatus(200);
    }

    /**
     * Test user achievement endpoint containt expect json.
     *
     * @return void
     */
    public function test_user_achievement_endpoint_containt_expect_json()
    {
        $response = $this->get("/users/{$this->user->id}/achievements");
        $response->assertJson([
            'unlocked_achievements' => [],
            'next_available_achievements' => [],
            'current_badge' => $this->firstBadge->description,
            'next_badge' => "",
            'remaing_to_unlock_next_badge' => 0,
        ]);
    }

    /**
     * Test user fire unlocked event and showing it returnd in unlocked achievements.
     *
     * @return void
     */
    public function test_user_fire_unlocked_event_and_showing_it_returnd_in_unlocked_achievements()
    {
        $this->user->unlock($this->firstCommentWritten);

        $response = $this->get("/users/{$this->user->id}/achievements");
        $response->assertJsonFragment([
            'unlocked_achievements' => [$this->firstCommentWritten->name],
            'next_available_achievements' => [],
        ]);
    }

    /**
     * Test fire add progress with unlock points achievement and showing it returnd in unlocked achievements.
     *
     * @return void
     */
    public function test_fire_add_progress_with_unlock_points_achievement_and_showing_it_returnd_in_unlocked_achievements()
    {
        $this->user->addProgress($this->firstCommentWritten, 1);

        $response = $this->get("/users/{$this->user->id}/achievements");
        $response->assertJsonFragment([
            'unlocked_achievements' => [$this->firstCommentWritten->name],
            'next_available_achievements' => [],
        ]);
    }

    /**
     * Test unlocked more than one achievement and showing in unlocked achievements.
     *
     * @return void
     */
    public function test_unlocked_more_than_one_achievement_and_showing_in_unlocked_achievements()
    {
        $this->user->unlock($this->firstCommentWritten);
        $this->user->unlock($this->fiveCommentsWritten);

        $response = $this->get("/users/{$this->user->id}/achievements");
        $response->assertJsonFragment([
            'unlocked_achievements' => [$this->firstCommentWritten->name, $this->fiveCommentsWritten->name],
            'next_available_achievements' => [],
        ]);
    }

    /**
     * Test fire add progress achievement and showing it returnd in next available achievements and empty unlocked achievements.
     *
     * @return void
     */
    public function test_fire_add_progress_achievement_and_showing_it_returnd_in_next_available_achievements_and_empty_unlocked_achievements()
    {
        $this->user->addProgress($this->fiveCommentsWritten, 1);

        $response = $this->get("/users/{$this->user->id}/achievements");
        $response->assertJsonFragment([
            'unlocked_achievements' => [],
            'next_available_achievements' => [$this->fiveCommentsWritten->name],
        ]);
    }

    /**
     * Test fire unlocked and add progress achievement and showing it returnd in unlocked achievements and next available achievements.
     *
     * @return void
     */
    public function test_fire_unlocked_and_add_progress_achievement_and_showing_it_returnd_in_unlocked_achievements_and_next_available_achievements()
    {
        $this->user->unlock($this->firstCommentWritten);
        $this->user->addProgress($this->fiveCommentsWritten, 1);

        $response = $this->get("/users/{$this->user->id}/achievements");
        $response->assertJsonFragment([
            'unlocked_achievements' => [$this->firstCommentWritten->name],
            'next_available_achievements' => [$this->fiveCommentsWritten->name],
        ]);
    }

    /**
     * Test add progress more than one achievement with same type and showing in next available achievements.
     *
     * @return void
     */
    public function test_add_progress_more_than_one_achievement_with_same_type_and_showing_in_next_available_achievements()
    {
        $this->user->addProgress($this->threeCommentsWritten, 1);
        $this->user->addProgress($this->fiveCommentsWritten, 1);

        $response = $this->get("/users/{$this->user->id}/achievements");
        $response->assertJsonFragment([
            'unlocked_achievements' => [],
            'next_available_achievements' => [$this->threeCommentsWritten->name],
        ]);
    }

    /**
     * Test add progress more than one achievement with differant type and showing in next available achievements.
     *
     * @return void
     */
    public function test_add_progress_more_than_one_achievement_with_differant_type_and_showing_in_next_available_achievements()
    {
        $this->user->addProgress($this->fiveCommentsWritten, 1);
        $this->user->addProgress($this->fiveLessonsWatched, 1);

        $response = $this->get("/users/{$this->user->id}/achievements");
        $response->assertJsonFragment([
            'unlocked_achievements' => [],
            'next_available_achievements' => [$this->fiveCommentsWritten->name, $this->fiveLessonsWatched->name],
        ]);
    }

    /**
     * Test next badge after fire achievement.
     *
     * @return void
     */
    public function test_next_badge_after_fire_achievement()
    {
        $this->user->unlock($this->firstCommentWritten);
        $this->user->addProgress($this->fiveCommentsWritten, 1);

        $response = $this->get("/users/{$this->user->id}/achievements");
        $response->assertJsonFragment([
            'current_badge' => $this->firstBadge->description,
            'next_badge' => $this->secondBadge->description,
        ]);
    }

    /**
     * Test unlocked achievement and showing in remaing to unlock next badge correct value.
     *
     * @return void
     */
    public function test_unlocked_achievement_and_showing_in_remaing_to_unlock_next_badge_correct_value()
    {
        $this->user->unlock($this->firstCommentWritten);
        $this->user->addProgress($this->fiveCommentsWritten, 1);

        $response = $this->get("/users/{$this->user->id}/achievements");
        $response->assertJsonFragment([
            'current_badge' => $this->firstBadge->description,
            'next_badge' => $this->secondBadge->description,
            'remaing_to_unlock_next_badge' => $this->secondBadge->points - 1,
        ]);
    }

    /**
     * Test unlocked more than one achievement and showing in remaing to unlock next badge correct value.
     *
     * @return void
     */
    public function test_unlocked_more_than_one_achievement_and_showing_in_remaing_to_unlock_next_badge_correct_value()
    {
        $this->user->unlock($this->firstCommentWritten);
        $this->user->unlock($this->fiveLessonsWatched);

        $response = $this->get("/users/{$this->user->id}/achievements");
        $response->assertJsonFragment([
            'current_badge' => $this->firstBadge->description,
            'next_badge' => $this->secondBadge->description,
            'remaing_to_unlock_next_badge' => $this->secondBadge->points - 2,
        ]);
    }
}
