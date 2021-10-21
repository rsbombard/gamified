<?php

namespace Bomb\Gamify;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class Quest
 * @package Bomb\Gamify
 * @property int actions_required
 * @property int completions
 * @property string progress_event
 * @property string max_user_completions
 * @property string requirement_type
 * @property array requirement_conditions
 */
class Quest extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $currentActiveQuest = null;
    protected $appends = ['active_quest', 'image'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'requirement_conditions' => 'array'
    ];

    public function recordCompletion() {
        $this->increment("completions");
    }

    public function isCountrySupported($country)
    {
        if ($this->geos == "all") {
            return true;
        }

        return stristr($this->geos, $country) !== false;
    }

    public function getActiveQuestAttribute()
    {
        return $this->currentActiveQuest;
    }

    public function getImageAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }

        return $this->getDefaultIcon();
    }

    public function loadQuestProgress($userId,\Illuminate\Support\Collection $activeQuests) {

        $this->currentActiveQuest = $activeQuests
            ->where("user_id", $userId)
            ->where("quest_id", $this->id)
            ->first();

        return $this;

    }

    /**
     * Get the default icon if not provided
     *
     * @return string
     */
    protected function getDefaultIcon()
    {
        return sprintf(
            '%s/%s%s',
            rtrim(config('gamify.quest_icon_folder', 'images/quests'), '/'),
            Str::kebab($this->name),
            config('gamify.quest_icon_extension', '.svg')
        );
    }
}
