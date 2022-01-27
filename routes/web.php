<?php

use App\Models\User;
use App\Models\Lesson;
use App\Models\Comment;
use App\Events\LessonWatched;
use App\Events\CommentWritten;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AchievementsController;

Route::get('/users/{user}/achievements', [AchievementsController::class, 'index']);


Route::get('/', function () {
    $user = User::first();
    $lesson = Lesson::first();
    $comment = Comment::first();

    LessonWatched::dispatch($lesson, $user);
    CommentWritten::dispatch($comment);
});
