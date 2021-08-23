<?php

namespace Bomb\Gamify;

use Bomb\Gamify\Events\QuestComplete;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserQuest extends Model
{
    protected $table = "user_quests";
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * This will be called when a QuestEvent is trigerred with the action matching this events "progress_event" attribute.
     * @param Quest $quest
     * @param int $progressIncrement
     * @return bool
     */
    public function recordProgress(Quest $quest, $progressIncrement = 1) {
        $this->progress += $progressIncrement;

        /* Quest completed! */
        if ($this->progress >= $quest->actions_Required
            && $this->num_completions < $quest->max_user_completions
        ) {
            $this->status = "complete";
            $this->finish_date = \Carbon\Carbon::now()->toDateTimeString();
            $this->percent_progress = 100;
            $quest->recordCompletion();
            $this->save();

            QuestComplete::dispatch($this);
            return true;
        }

        /* Quest Progress Updated */
        $this->percent_progress = round(($this->progress / $quest->actions_required * 100), 0);
        $this->save();
        return false;
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    public function quest(){
        return $this->belongsTo(Quest::class, "quest_id");
    }

}