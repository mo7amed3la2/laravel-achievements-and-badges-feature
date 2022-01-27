<?php

use App\Models\User;
use App\Models\Lesson;
use App\Models\Comment;
use App\Events\LessonWatched;
use App\Events\CommentWritten;
use App\Events\AchievementUnlocked;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AchievementsController;

Route::get('/users/{user}/achievements', [AchievementsController::class, 'index']);


Route::get('/', function () {
    $user = User::first();

    event(new AchievementUnlocked('Test', $user));

    return 'aa';
    $lesson = Lesson::first();
    $comment = Comment::first();
    LessonWatched::dispatch($lesson, $user);
    CommentWritten::dispatch($comment);
});
