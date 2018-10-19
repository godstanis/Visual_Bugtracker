<?php

namespace App\Providers;

use App\Custom\Pusher\Channels\AbstractChannel;
use App\Custom\Pusher\Channels\BoardChannel;
use Illuminate\Support\ServiceProvider;
use Pusher\Pusher;

class PusherServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind(Pusher::class, function(){
            $data = config('broadcasting.connections.pusher');
            return new Pusher($data['key'], $data['secret'], $data['app_id'], $data['options']);
        });
        
        app()->bind(AbstractChannel::class, function($app, $parameters){
            return new BoardChannel($parameters['channel_name']);
        });
    }
}
