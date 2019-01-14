<?php

namespace Therilion\Timerizable;

use Illuminate\Support\Facades\Route;

class Timerizable
{
    // Build wonderful things
    public static function apiRoutes()
    {
        Route::apiResource('time-blocks', '\Therilion\Timerizable\Http\Controllers\Api\TimeBlockController');
        Route::apiResource('time-blocks.time-intervals', '\Therilion\Timerizable\Http\Controllers\Api\TimeIntervalController');
    }
}