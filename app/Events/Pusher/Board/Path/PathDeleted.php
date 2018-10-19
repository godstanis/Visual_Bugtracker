<?php

namespace App\Events\Pusher\Board\Path;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class PathDeleted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $board;
    /**
     * Path json resource will be returned as Pusher message
     * so we can catch it on frontend side.
     *
     * @var array
     */
    public $path_json;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(\App\Path $path)
    {
        $this->board = $path->board;
        $this->path_json = (new \App\Http\Resources\PathResource($path))->toArray((new \Illuminate\Http\Request()));
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('board_'.$this->board->id);
    }

    /**
     * Event name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'userDeletedPath';
    }
}
