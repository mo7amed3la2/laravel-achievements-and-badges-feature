<?php

namespace Tests;

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use App\Achievements\Comments\FirstCommentWritten;
use App\Achievements\Comments\FiveCommentsWritten;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

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
}
