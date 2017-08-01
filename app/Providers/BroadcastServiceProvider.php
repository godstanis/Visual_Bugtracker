<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;


class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Pusher authorization is extended to PusherAuthController.php
        /*
        Broadcast::routes();

        //require base_path('routes/channels.php');

        */
    }
}
