<?php

namespace App\Listeners;

use App\Events\CommentWritten;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Achievements\Comments\TenCommentsWritten;
use App\Achievements\Comments\FirstCommentWritten;
use App\Achievements\Comments\FiveCommentsWritten;
use App\Achievements\Comments\ThreeCommentsWritten;
use App\Achievements\Comments\TwentyCommentsWritten;

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
        //
        $user = $event->comment->user;
        $user->unlock(new FirstCommentWritten());
        $user->addProgress(new ThreeCommentsWritten(), 1);
        // $user->addProgress(new FiveCommentsWritten(), 1);
        // $user->addProgress(new TenCommentsWritten(), 1);
        // $user->addProgress(new TwentyCommentsWritten(), 1);
    }
}
