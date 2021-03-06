<?php

namespace Bomb\Gamify\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class XpChanged implements ShouldBroadcast
{
    use Dispatchable;

    /**
     * @var Model
     */
    public $subject;

    /**
     * @var int
     */
    public $xp;

    /**
     * @var bool
     */
    public $increment;

    /**
     * Create a new event instance.
     *
     * @param $subject
     * @param $xp integer
     * @param $increment
     */
    public function __construct(Model $subject, int $xp, bool $increment)
    {
        $this->subject = $subject;
        $this->xp = $xp;
        $this->increment = $increment;
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
