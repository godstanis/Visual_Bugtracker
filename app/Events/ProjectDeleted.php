<?php

namespace App\Events;

use App\Project;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ProjectDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $project_id;    

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($project_id)
    {
        $this->project_id = $project_id;
    }

}
