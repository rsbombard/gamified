<?php

namespace Bomb\Gamify\Events;

use Bomb\Gamify\Quest;
use Bomb\Gamify\UserQuest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class QuestComplete implements ShouldBroadcast
{
    use Dispatchable;

    /**
     * @var UserQuest;
     */
    public $userQuest;

    /**
     * @var \App\User
     */
    public $user;

    /**
     * @var Quest
     */
    public $quest;



    /**
     * QuestEvent constructor.
     * @param \App\User $user
     * @param UserQuest $userQuest
     * @param Quest $quest
     */
    public function __construct(\App\User $user, UserQuest $userQuest, Quest $quest)
    {
        $this->userQuest = $userQuest;
        $this->user = $user;
        $this->quest = $quest;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|\Illuminate\Broadcasting\Channel[]
     */
    public function broadcastOn()
    {
        $channelName = config('gamify.channel_name') . $this->user->id;

        if (config('gamify.broadcast_on_private_channel')) {
            return new PrivateChannel($channelName);
        }

        return new Channel($channelName);
    }
}
