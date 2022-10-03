<?php

namespace App\Listeners;

use App\Events\BarangStored;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\BarangCreated;
use Illuminate\Support\Facades\Mail;

class SendEmailToUser implements ShouldQueue
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
     * @param  \App\Events\BarangStored  $event
     * @return void
     */
    public function handle(BarangStored $event)
    {
        Mail::to("admin@gmail.com")->send(new BarangCreated($event->data));
    }
}
