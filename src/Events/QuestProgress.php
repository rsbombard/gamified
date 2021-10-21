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
     * @var int
     */
    public $progressIncrement;
    public $progressIdentifier; //a specific offer wall, feature or unique identifier to record
    public $progressValue; //value of the recorded progress event, such as Coin balance, item number etc.
    public $questEventAction;


    /**
     * QuestEvent constructor.
     * @param \App\User $user
     * @param $questEventAction
     * @param int $progressIncrement
     * @param string $progressIdentifier
     * @param string $progressValue
     */
    public function __construct(\App\User $user,
                                $questEventAction,
                                $progressIncrement = 1,
                                $progressIdentifier = "",
                                $progressValue = ""
    )
    {
        $this->user = $user;
        $this->progressIncrement = $progressIncrement;
        $this->questEventAction = $questEventAction;
        $this->progressIdentifier = $progressIdentifier;
        $this->progressValue = $progressValue;
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
