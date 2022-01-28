<?php

use App\Achievements\Comments\FiveCommentsWritten;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Comment;
use App\Events\LessonWatched;
use App\Events\CommentWritten;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AchievementsController;

Route::get('/users/{user}/achievements', [AchievementsController::class, 'index']);


Route::get('/fire-events', function () {
    $user = User::first();

    Lesson::factory()
        ->count(1)
        ->create();

    $lesson  = Lesson::latest()->first();
    $user->lessons()->attach([$lesson->id => ['watched' => true]]);
    LessonWatched::dispatch($lesson, $user);


    Comment::factory()
        ->count(1)
        ->create();

    $comment = Comment::latest()->first();
    CommentWritten::dispatch($comment);
});
