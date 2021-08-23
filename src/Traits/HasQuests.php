<?php

namespace Bomb\Gamify\Traits;

use Bomb\Gamify\Badge;
use Bomb\Gamify\Quest;
use Bomb\Gamify\UserQuest;
use Gamify;

trait HasQuests
{

    public function quests()
    {
        return Quest::
            where("start_date", "<", \Carbon\Carbon::now()->toDateTimeString())
            ->where("end_date", ">", \Carbon\Carbon::now()->toDateTimeString())
            ->get();
    }

    public function activeQuests()
    {
        return $this->hasMany(UserQuest::class);
    }

}
