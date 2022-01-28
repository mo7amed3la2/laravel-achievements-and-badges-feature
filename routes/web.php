<?php

use App\Models\User;
use App\Models\Lesson;
use App\Models\Comment;
use App\Models\Achievement;
use App\Events\LessonWatched;
use App\Events\CommentWritten;
use App\Models\AchievementProgress;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AchievementsController;

Route::get('/users/{user}/achievements', [AchievementsController::class, 'index']);


Route::get('/', function () {
    $user = User::first();
    $lesson = Lesson::first();

    Comment::factory()
            ->count(1)
            ->create();

    $comment = Comment::latest()->first();

    LessonWatched::dispatch($lesson, $user);
    CommentWritten::dispatch($comment);
});


Route::get('/test', function () {
    $type = 'lesson_watched';
    $achievement = AchievementProgress::whereHas('achievement', function ($q) use ($type) {
        $q->where('type', $type);
    })->get()->max('points');
    dd($achievement);
});
