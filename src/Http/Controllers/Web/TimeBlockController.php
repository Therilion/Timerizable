<?php

namespace Therilion\Timerizable\Http\Controllers\Web;

use Therilion\Timerizable\Model\TimeBlock;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Therilion\Timerizable\Http\Requests\TimeBlockRequest;

class TimeBlockController extends BaseController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MessageBag $messages, TimeBlockRequest $request)
    {
        $timeBlock = new TimeBlock($request->all());
        $timeBlock->save();
        $messages->add('success', __('timerizable.time_block_stored'));
        $route = '/';
        try{
            $route = route(
                config('timerizable.web.time_blocks_store', 'home'),
                [
                    'timeblock' => $timeBlock->id,
                    'timeblock_object' => $timeBlock,
                ]
            );
        } catch(\Exception $ex) {
            $messages->add('errors', __('timerizable.route_error', ['place' => get_class($this) . '@store']));
            $messages->add('errors', $ex->getMessage());
        }
        return redirect($route)->with('messages', $messages);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Therilion\Timerizable\Model\TimeBlock  $timeBlock
     * @return \Illuminate\Http\Response
     */
    public function update(MessageBag $messages, TimeBlockRequest $request, TimeBlock $timeBlock)
    {
        $timeBlock->fill($request->all());
        $timeBlock->save();
        $messages->add('success', __('timerizable.time_block_updated'));
        $route = '/';
        try{
            $route = route(
                config('timerizable.web.time_blocks_update', 'home'),
                [
                    'timeblock' => $timeBlock->id,
                    'timeblock_object' => $timeBlock,
                ]
            );
        } catch(\Exception $ex) {
            $messages->add('errors', __('timerizable.route_error', ['place' => get_class($this) . '@store']));
            $messages->add('errors', $ex->getMessage());
        }
        return redirect($route)->with('messages', $messages);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Therilion\Timerizable\Model\TimeBlock  $timeBlock
     * @return \Illuminate\Http\Response
     */
    public function destroy(MessageBag $messages, TimeBlock $timeBlock)
    {
        $timeBlock->delete();
        $messages->add('success', __('timerizable.time_block_deleted'));
        $route = '/';
        try{
            $route = route(
                config('timerizable.web.time_blocks_delete', 'home'),
                [
                    'timeblock' => $timeBlock->id,
                    'timeblock_object' => $timeBlock,
                ]
            );
        } catch(\Exception $ex) {
            $messages->add('errors', __('timerizable.route_error', ['place' => get_class($this) . '@store']));
            $messages->add('errors', $ex->getMessage());
        }
        return redirect($route)->with('messages', $messages);
    }
}
