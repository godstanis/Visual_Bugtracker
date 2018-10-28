<?php

namespace App\Custom\Pusher\Channels;

use App\Board;

class BoardChannel extends \App\Custom\Pusher\Channels\AbstractChannel
{

    /**
     * @param \App\User $user
     * @return mixed Flag that indicates authorization status
     */
    public function getUserAuthorizationStatus(\App\User $user): bool
    {
        $board = Board::findOrFail($this->getIdentificator());

        if($board !== false) {
            return $user->can('view', $board);
        }

        return false;
    }

    /**
     * @return bool|int
     */
    private function getIdentificator()
    {
        $channel_name = $this->channel_name;
        
        $matches = [];
        $preg_match = preg_match('/(\d+)/', $channel_name, $matches);

        if(!$preg_match && !is_numeric($matches[1])) {
            return false;
        }

        return (int)$matches[1];
    }

}
