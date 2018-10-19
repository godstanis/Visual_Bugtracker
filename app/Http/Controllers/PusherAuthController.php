<?php

namespace App\Http\Controllers;

use App\Custom\Pusher\Channels\AbstractChannel;
use Illuminate\Http\Request;

use App\Custom\Pusher\ChannelAccessManager;

class PusherAuthController extends Controller
{
    public function authorizeBoardChannel(Request $request)
    {
        $channel_access_manager = new ChannelAccessManager(
            app()->makeWith(AbstractChannel::class, ['channel_name'=>$request->channel_name]),
            auth()->user()
        );

        return $channel_access_manager->response($request);
    }
}
