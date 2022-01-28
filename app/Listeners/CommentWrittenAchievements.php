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
        $countUserComments = $user->watched->count();

        $achivements = [
            new FirstCommentWritten(),
            new ThreeCommentsWritten(),
            new FiveCommentsWritten(),
            new TenCommentsWritten(),
            new TwentyCommentsWritten(),
        ];
        
        foreach ($achivements as $achivement) {
            if ($countUserComments >= $achivement->points) {
                $user->unlock($achivement);
            } else {
                // to handle the scenario user already add comments before achievement assigned.
                $user->setProgress($achivement, $countUserComments);
            }
        }
    }
}
