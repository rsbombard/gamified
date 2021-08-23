<?php

namespace Bomb\Gamify\Listeners;

use Bomb\Gamify\Events\QuestProgress;
use Bomb\Gamify\Quest;
use Bomb\Gamify\UserQuest;

class UpdateQuestProgress
{
    /**
     * Handle the event.
     * @param QuestProgress $event
     * @return void
     */
    public function handle(QuestProgress $event)
    {
        $matchingQuests = Quest::where("progress_event", $event->questEventAction)
            ->where("start_date", "<", \Carbon\Carbon::now()->toDateTimeString())
            ->where("end_date", ">", \Carbon\Carbon::now()->toDateTimeString())
            ->get();

        foreach ($matchingQuests as $quest) {
            $userQuest = UserQuest::firstOrCreate(
                ['quest_id' => $quest->id, 'user_id' => $event->user->id],
                [
                    'progress' => 0,
                    'num_completions' => 0,
                ]);

            /* Touch start date for new quest recordings */
            if ($userQuest->wasRecentlyCreated) {
                $userQuest->start_date = \Carbon\Carbon::now()->toDateTimeString();
            }

            /* Quest has reached limit for this user */
            if ($userQuest->num_completions >= $quest->max_user_completions) {
                return;
            }

            /* Update the progress on this users quest */
            $userQuest->recordProgress($quest, $event->progressIncrement);

         }
    }
}
