<?php

namespace Bomb\Gamify\Facades;

use Illuminate\Support\Facades\Facade;

class GamifyFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'gamify';
    }
}
