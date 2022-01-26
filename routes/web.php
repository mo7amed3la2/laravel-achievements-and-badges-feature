<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Achievements\FiveLessonsWatched;
use App\Achievements\FirstLessonWatched;
use App\Http\Controllers\AchievementsController;

Route::get('/users/{user}/achievements', [AchievementsController::class, 'index']);


Route::get('/',function(){
    $user = User::first(); 
    $user->addProgress(new FirstLessonWatched(),1);
});