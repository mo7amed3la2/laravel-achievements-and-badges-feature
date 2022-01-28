<?php

namespace Tests;

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use App\Achievements\Comments\FirstCommentWritten;
use App\Achievements\Comments\FiveCommentsWritten;
use App\Achievements\Comments\ThreeCommentsWritten;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public $users;

    public $firstCommentWritten;

    public $threeCommentsWritten;

    public $fiveCommentsWritten;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:fresh');
        Artisan::call('migrate');
        $this->user = User::factory()->create();

        $this->firstCommentWritten = new FirstCommentWritten();
        $this->threeCommentsWritten = new ThreeCommentsWritten();
        $this->fiveCommentsWritten = new FiveCommentsWritten();
    }
}
