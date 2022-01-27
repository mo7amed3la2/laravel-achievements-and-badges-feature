<?php

namespace App\Providers;

use App\Events\BadgeUnlocked;
use App\Events\LessonWatched;
use App\Models\BadgeProgress;
use App\Events\CommentWritten;
use App\Events\AchievementUnlocked;
use App\Models\AchievementProgress;
use Illuminate\Support\Facades\Event;
use App\Listeners\BadgeUnlockedListener;
use App\Observers\BadgeProgressObserver;
use App\Listeners\CommentWrittenAchievements;
use App\Listeners\LessonsWatchedAchievements;
use App\Listeners\AchievementUnlockedListener;
use App\Observers\AchievementProgressObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CommentWritten::class => [
            CommentWrittenAchievements::class
        ],
        LessonWatched::class => [
            LessonsWatchedAchievements::class
        ],
        AchievementUnlocked::class => [
            AchievementUnlockedListener::class   
        ],
        BadgeUnlocked::class => [
            BadgeUnlockedListener::class   
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        AchievementProgress::observe(AchievementProgressObserver::class);
        BadgeProgress::observe(BadgeProgressObserver::class);
    }
}
