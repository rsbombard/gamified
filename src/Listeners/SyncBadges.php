<?php

namespace Bomb\Gamify\Listeners;

use Bomb\Gamify\Events\XpChanged;

class SyncBadges
{
    /**
     * Handle the event.
     *
     * @param  XpChanged  $event
     * @return void
     */
    public function handle(XpChanged $event)
    {
        $event->subject->syncBadges();
    }
}
