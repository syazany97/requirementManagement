<?php

namespace App\Observers;

use App\Models\Comment\Comment;

class CommentObserver
{
    public function creating(Comment $comment)
    {
        if (empty($comment->user_id)) {
            $comment->user_id = auth()->user()->id;
        }
    }

    public function created(Comment $comment)
    {
        //
    }

    /**
     * Handle the comment "updated" event.
     *
     * @param \App\Models\Comment\Comment $comment
     * @return void
     */
    public function updated(Comment $comment)
    {
        //
    }

    /**
     * Handle the comment "deleted" event.
     *
     * @param \App\Models\Comment\Comment $comment
     * @return void
     */
    public function deleted(Comment $comment)
    {
        //
    }

    /**
     * Handle the comment "restored" event.
     *
     * @param \App\Models\Comment\Comment $comment
     * @return void
     */
    public function restored(Comment $comment)
    {
        //
    }

    /**
     * Handle the comment "force deleted" event.
     *
     * @param \App\Models\Comment\Comment $comment
     * @return void
     */
    public function forceDeleted(Comment $comment)
    {
        //
    }
}
