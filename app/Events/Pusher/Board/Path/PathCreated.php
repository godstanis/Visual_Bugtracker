<?php

namespace App\Events\Pusher\Board\Path;

use App\Path;
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
    public function __construct(Path $path)
    {
        $this->path = $path;

        $this->path_json = (new \App\Http\Resources\Path\PathResource($path))->toArray((new \Illuminate\Http\Request()));
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('board_'.$this->path->board_id);
    }

    /**
     * Event name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'userCreatedPath';
    }
}
