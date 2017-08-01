<?php

namespace App\Custom\Pusher\Channels;

abstract class AbstractChannel
{

    public $channel_name;

    public function __construct($channel_name)
    {
        $this->channel_name = $channel_name;
    }

    abstract public function getUserAuthorizationStatus(\App\User $user);

}