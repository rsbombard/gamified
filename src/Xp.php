<?php

namespace Bomb\Gamify;

use Illuminate\Database\Eloquent\Model;

class Xp extends Model
{
    protected $guarded = [];

    /**
     * Xp Gamify Group
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gamifyGroup()
    {
        return $this->belongsTo(GamifyGroup::class);
    }

    public function isAchieved($subject)
    {
        if (class_exists($this->class)) {
            return ((new $this->class)($this, $subject));
        }

        return config('gamify.xp_is_achieved');
    }

    /**
     * @param $subject
     *
     * @return \Illuminate\Config\Repository|mixed
     */
    public function getXp($subject)
    {
        if (class_exists($this->class)) {
            $class = new $this->class;
            if (method_exists($class, 'getDynamicXp')) {
                return $class->getDynamicXp($this, $subject);
            }
        }

        return $this->xp;
    }
}
