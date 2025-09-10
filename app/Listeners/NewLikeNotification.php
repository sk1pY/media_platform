<?php

namespace App\Listeners;

use App\Events\NewLike;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class NewLikeNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewLike $event): void
    {
        $event->author->notify(
            new \App\Notifications\NewLikeNotification(
                $event->user,
                $event->author,
                $event->post)
        );
    }
}
