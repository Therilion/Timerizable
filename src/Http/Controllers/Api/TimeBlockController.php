<?php

namespace Therilion\Timerizable\Http\Controllers\Api;

use Therilion\Timerizable\Model\TimeBlock;
use Illuminate\Http\Request;
use Therilion\Timerizable\Http\Requests\TimeBlockRequest;

class TimeBlockController extends \Illuminate\Routing\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paginate = $request->paginate ?? config('timerizable.api.time_blocks_paginate', 0);
        
        if(is_numeric($paginate) && $paginate > 1) {
            $timeblocks = TimeBlock::paginate(intval($paginate));
            $timeblocks->load('time_intervals');
        } else {

            $timeblocks = ['data' => TimeBlock::all()];
            $timeblocks['data']->load('time_intervals');
        }
        return response()->json($timeblocks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TimeBlockRequest $request)
    {
        $timeblock = new TimeBlock;
        $timeblock->fill($request->all());
        $timeblock->save();
        return response()->json($timeblock, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Therilion\Timerizable\Model\TimeBlock  $timeBlock
     * @return \Illuminate\Http\Response
     */
    public function show(TimeBlock $timeBlock)
    {
        $timeBlock->load('time_intervals');
        return response()->json($timeBlock);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Therilion\Timerizable\Model\TimeBlock  $timeBlock
     * @return \Illuminate\Http\Response
     */
    public function update(TimeBlockRequest $request, TimeBlock $timeBlock)
    {
        $timeBlock->fill($request->all());
        $timeBlock->save();
        return response()->json($timeBlock, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Therilion\Timerizable\Model\TimeBlock  $timeBlock
     * @return \Illuminate\Http\Response
     */
    public function destroy(TimeBlock $timeBlock)
    {
        $timeBlock->delete();
        return response()->json([], 204);
    }
}
