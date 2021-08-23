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
    use Dispatchable, SerializesModels;

    /**
     * @var \App\User;
     */
    public $user;

    /**
     * @var int
     */
    public $progressIncrement;

    public $questEventAction;


    /**
     * QuestEvent constructor.
     * @param \App\User $user
     * @param $questEventAction
     * @param int $progressIncrement
     */
    public function __construct(\App\User $user, $questEventAction, $progressIncrement = 1)
    {
        $this->user = $user;
        $this->progressIncrement = $progressIncrement;
        $this->questEventAction = $questEventAction;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|\Illuminate\Broadcasting\Channel[]
     */
    public function broadcastOn()
    {
        $channelName = config('gamify.channel_name') . $this->subject->getKey();

        if (config('gamify.broadcast_on_private_channel')) {
            return new PrivateChannel($channelName);
        }

        return new Channel($channelName);
    }
}
