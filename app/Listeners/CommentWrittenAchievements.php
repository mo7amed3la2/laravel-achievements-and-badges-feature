<?php

namespace App\Listeners;

use App\Events\CommentWritten;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\AchievementsGroup\CommentsAchievementsGroup;

class CommentWrittenAchievements
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\CommentWritten  $event
     * @return void
     */
    public function handle(CommentWritten $event)
    {
        $user = $event->comment->user;
        $countUserComments = $user->watched->count();

        // adding progress point to user.
        (new CommentsAchievementsGroup)->addGroupProgress($user, $countUserComments);
    }
}
