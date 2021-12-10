<?php

namespace Bomb\Gamify;

use Bomb\Gamify\Events\QuestComplete;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class UserQuest
 * @package Bomb\Gamify
 * @property array progress_identifiers
 * @property integer actions_today
 * @property integer actions_yesterday
 * @property integer progress
 * @property integer percent_progress
 * @property integer num_completions
 * @property string status
 * @property \Carbon\Carbon finish_date
 * @property \Carbon\Carbon start_date
 */
class UserQuest extends Model
{
    protected $table   = "user_quests";
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $casts   = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'start_date' => 'datetime',
        'finish_date' => 'datetime',
        'progress_identifiers' => 'array'
    ];

    const STATUS_IN_PROGRESS = "in_progress";
    const STATUS_COMPLETE = "complete";
    const STATUS_SKIPPED = "skipped";
    const STATUS_VERIFICATION = "pending_verification";
    const STATUS_INVALID = "invalid";

    /**
     * This will be called when a QuestEvent is trigerred with the action matching this events "progress_event" attribute.
     * @param Quest $quest
     * @param int $progressIncrement
     * @return bool
     */
    public function recordProgress(Quest $quest, $progressIncrement = 1)
    {
        $this->progress += $progressIncrement;
        $this->progress = min($quest->actions_required, $this->progress);
        $this->actions_today += $progressIncrement;
        $this->actions_today = min($quest->actions_required, $this->actions_today);

        /* Quest completed! */
        if ($this->progress >= $quest->actions_required
            && $this->num_completions < $quest->max_user_completions
            && $this->status != 'complete'
        ) {
            $this->status           = "complete";
            $this->finish_date      = \Carbon\Carbon::now()->toDateTimeString();
            $this->percent_progress = 100;
            $this->num_completions++;
            $quest->recordCompletion();
            $this->save();

            QuestComplete::dispatch($this->user, $this, $quest);
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

    public function quest()
    {
        return $this->belongsTo(Quest::class, "quest_id");
    }

    public function toStatArray()
    {
        return [
            'id'          => $this->quest->id,
            'name'        => $this->quest->name,
            'description' => $this->quest->description,
            'nice_date'   => $this->finish_date
        ];
    }

}
