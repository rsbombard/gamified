<?php

namespace Bomb\Gamify\Traits;

use Bomb\Gamify\Events\XpChanged;
use Bomb\Gamify\Xp;

trait HasXp
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\morphMany
     */
    public function xp()
    {
        return $this->morphToMany(Xp::class, 'xpable')->withPivot(['achieved_xp']);
    }

    public function getAchievedXpAttribute()
    {
        return $this->xp()->sum('achieved_xp');
    }

    /**
     * Reset a user xp to zero
     *
     * @param bool $event
     *
     * @return mixed
     */
    public function resetXp($event = true)
    {
        $this->xp()->delete();

        if ($event) {
            XpChanged::dispatch($this, 0, false);
        }

        return $this;
    }


    /**
     * @param \Bomb\Gamify\Xp $xp
     *
     * @param bool $event
     *
     * @return $this
     */
    public function achieveXp(Xp $xp, $event = true)
    {
        $achieved_xp = $xp->getXp($this);
        $this->xp()->attach([$xp->id => ['achieved_xp' => $achieved_xp]]);

        if ($event) {
            XpChanged::dispatch($this, $achieved_xp, true);
        }

        return $this;
    }

    /**
     * @param $xp
     * @param bool $event
     *
     * @return $this
     */
    public function undoXp($xp, $event = true)
    {
        $this->xp()->detach($xp);

        if ($event) {
            XpChanged::dispatch($this, $xp->getXp($this), false);
        }

        return $this;
    }
}
