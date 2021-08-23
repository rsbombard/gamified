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
 */
class Quest extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

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

    public function getImageAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }

        return $this->getDefaultIcon();
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
