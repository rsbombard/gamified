<?php

namespace Bomb\Gamify\Events;

use Bomb\Gamify\Quest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class QuestProgress implements ShouldBroadcast
{
    use Dispatchable;

    /**
     * @var \App\User;
     */
    public $user;

    /**
     * @var QuestProgressDetails
     */
    public $details;


    /**
     * QuestEvent constructor.
     * @param \App\User $user
     * @param QuestProgressDetails $details
     */
    public function __construct(\App\User $user,
                                QuestProgressDetails $details
    )
    {
        $this->user    = $user;
        $this->details = $details;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|\Illuminate\Broadcasting\Channel[]
     */
    public function broadcastOn()
    {
        $channelName = config('gamify.channel_name');

        if (config('gamify.broadcast_on_private_channel')) {
            $channelName = config('gamify.channel_name') . "." . $this->user->id;
            return new PrivateChannel($channelName);
        }

        return new Channel($channelName);
    }
}
