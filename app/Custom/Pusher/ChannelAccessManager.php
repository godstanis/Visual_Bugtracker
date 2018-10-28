<?php

namespace App\Custom\Pusher;

use App\Custom\Pusher\Channels\AbstractChannel;
use Illuminate\Http\Request;
use Pusher\Pusher;

class ChannelAccessManager
{

    protected $channel;
    protected $user;

    public function __construct(AbstractChannel $channel, \App\User $user)
    {
        $this->channel = $channel;
        $this->user = $user;
    }

    public function response(Request $request)
    {
        $userAuthorized = $this->channel->getUserAuthorizationStatus($this->user);

        if ($userAuthorized) {
            $pusher = app()->make(Pusher::class);
          
            $data = $pusher->socket_auth($request->channel_name, $request->socket_id);

            return response($data, 200)
                ->header('Content-Type', 'application/json');
        }

        return response('User is not authorized to listen to this channel', 403)
            ->header('Content-Type', 'text/plain');
    }
}