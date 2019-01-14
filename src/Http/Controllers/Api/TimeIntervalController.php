<?php

namespace Therilion\Timerizable\Http\Controllers\Api;

use Therilion\Timerizable\Model\TimeBlock;
use Therilion\Timerizable\Model\TimeInterval;
use Illuminate\Http\Request;
use Therilion\Timerizable\Http\Requests\TimeIntervalRequest;

class TimeIntervalController extends \Illuminate\Routing\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, TimeBlock $timeBlock)
    {
        $paginate = $request->paginate ?? config('timerizable.api.time_blocks_paginate', 0);
        // $intervals = $timeBlock->time_intervals()->paginate(10);
        if(is_numeric($paginate) && $paginate > 1) {
            $intervals = $timeBlock->time_intervals()->paginate(intval($paginate));
        } else {
            $intervals = ['data' => $timeBlock->time_intervals];
        }
        return response()->json($intervals);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TimeIntervalRequest $request, TimeBlock $timeBlock)
    {
        $timeInterval = new TimeInterval();
        $timeInterval->fill($request->all());
        $timeBlock->time_intervals()->save($timeInterval);
        return response()->json($timeInterval, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\TimeInterval  $timeInterval
     * @return \Illuminate\Http\Response
     */
    public function show(TimeBlock $timeBlock, TimeInterval $timeInterval)
    {
        return response()->json($timeInterval);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\TimeInterval  $timeInterval
     * @return \Illuminate\Http\Response
     */
    public function update(TimeIntervalRequest $request, TimeBlock $timeBlock, TimeInterval $timeInterval)
    {
        $timeInterval->fill($request->all());
        $timeInterval->save();
        return response()->json($timeInterval);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\TimeInterval  $timeInterval
     * @return \Illuminate\Http\Response
     */
    public function destroy(TimeBlock $timeBlock, TimeInterval $timeInterval)
    {
        $timeInterval->delete();
        return response()->json([], 204);
    }
}
