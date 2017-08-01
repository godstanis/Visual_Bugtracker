<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        
        app()->bind('Pusher', function(){
            $data = config('broadcasting.connections.pusher');

            return new \Pusher($data['key'], $data['secret'], $data['app_id'], $data['options']);
        });
        
        app()->bind('AbstractChannel', function($app, $parameters){
            return new \App\Custom\Pusher\Channels\BoardChannel($parameters['channel_name']);
        });
    }
}
