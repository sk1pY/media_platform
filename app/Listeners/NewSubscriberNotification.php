<?php

namespace App\Listeners;

use App\Events\NewSubscriber;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewSubscriberNotification implements ShouldQueue
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
    public function handle(NewSubscriber $event): void
    {
        $event->subscribedTo->notify(
            new \App\Notifications\NewSubscriberNotification(
                $event->subscriber,
                $event->subscribedTo
            ));
    }
}
