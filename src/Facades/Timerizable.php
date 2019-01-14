<?php

namespace Therilion\Timerizable\Facades;

use Illuminate\Support\Facades\Facade;

class Timerizable extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'timerizable';
    }
}
