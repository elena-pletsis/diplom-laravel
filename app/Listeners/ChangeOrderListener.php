<?php

namespace App\Listeners;

use App\Events\ChangeOrderEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChangeOrderListener
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
     * @param  ChangeOrderEvent  $event
     * @return void
     */
    public function handle(ChangeOrderEvent $event)
    {
        \Log::info('order', $event->order->toArray());
    }
}
