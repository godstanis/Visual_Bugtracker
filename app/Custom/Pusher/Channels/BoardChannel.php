<?php

namespace App\Custom\Pusher\Channels;

use App\Board;

class BoardChannel extends \App\Custom\Pusher\Channels\AbstractChannel
{

    public function getUserAuthorizationStatus(\App\User $user)
    {
        $board = Board::findOrFail($this->getIdentificator());

        if($board)
        {
            return $user->can('view', $board);
        }

        return false;
    }

    private function getIdentificator()
    {
        $channel_name = $this->channel_name;
        
        $matches = [];
        $preg_match = preg_match('/(\d+)/', $channel_name, $matches);

        if(!$preg_match && !is_numeric($matches[1]))
        {
            return false;
        }

        return (int)$matches[1];
        
    }


}