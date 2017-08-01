<?php

namespace App\Events\Pusher;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class PathCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $path;
    public $path_json;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(\App\Path $path)
    {
        $this->path = $path;
        $this->path_json = $path->decodedJsonPath();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        //return new PrivateChannel('channel-name');

        return new PrivateChannel('board_'.$this->path->board_id);
        
    }

    public function broadcastAs()
    {
        return 'userCreatedPath';
    }
}
