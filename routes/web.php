<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Achievements\FiveLessonWatched;
use App\Achievements\FirstLessonWatched;
use App\Http\Controllers\AchievementsController;

Route::get('/users/{user}/achievements', [AchievementsController::class, 'index']);


Route::get('/',function(){
    $user = User::first(); 
    $user->unlock(new FiveLessonWatched());
});