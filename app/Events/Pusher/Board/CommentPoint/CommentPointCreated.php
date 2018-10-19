<?php

namespace App\Events\Pusher\Board\CommentPoint;

use App\CommentPoint;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class CommentPointCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * CommentPoint will be returned as Pusher message
     * so we can catch it on frontend side.
     *
     * @var CommentPoint
     */
    public $commentPoint;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CommentPoint $commentPoint)
    {
        $this->commentPoint = $commentPoint;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('board_'.$this->commentPoint->board_id);
    }

    /**
     * Event name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'userCreatedCommentPoint';
    }
}

