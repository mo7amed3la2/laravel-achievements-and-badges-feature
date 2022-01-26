<?php

use App\Models\User;
use App\Models\Lesson;
use App\Events\LessonWatched;
use Illuminate\Support\Facades\Route;
use App\Achievements\FirstLessonWatched;
use App\Achievements\FiveLessonsWatched;
use App\Http\Controllers\AchievementsController;

Route::get('/users/{user}/achievements', [AchievementsController::class, 'index']);


Route::get('/',function(){
    $user = User::first(); 
    $lesson = Lesson::first(); 
    // $user->addProgress(new FirstLessonWatched(),1);

    LessonWatched::dispatch($lesson,$user);
});