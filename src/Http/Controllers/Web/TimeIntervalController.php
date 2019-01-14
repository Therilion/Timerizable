<?php

namespace Therilion\Timerizable\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;
use Therilion\Timerizable\Model\TimeInterval;
use Therilion\Timerizable\Model\TimeBlock;
use Therilion\Timerizable\Http\Requests\TimeIntervalRequest;

class TimeIntervalController extends BaseController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MessageBag $messages, TimeIntervalRequest $request, TimeBlock $timeblock)
    {
        $timeinterval = new TimeInterval([
            'starts_at' => $request->starts_at,
            'ends_at'   => $request->ends_at,
        ]);
        $timeblock->time_intervals()->save($timeinterval);
        $messages->add('success', __('timerizable.time_interval_stored'));
        $route = '/';
        try{
            $route = route(
                config('timerizable.web.time_intervals_store', 'home'),
                [
                    'timeblock' => $timeblock->id,
                    'timeblock_object' => $timeblock,
                    'timeinterval' => $timeinterval->id,
                    'timeinterval_object' => $timeinterval,
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
     * @param  \Therilion\Timerizable\Model\TimeInterval  $timeInterval
     * @return \Illuminate\Http\Response
     */
    public function update(MessageBag $messages, TimeIntervalRequest $request, TimeBlock $timeblock, TimeInterval $timeInterval)
    {
        $timeInterval->starts_at = $request->starts_at;
        $timeInterval->ends_at   = $request->ends_at;
        $timeInterval->save();
        $messages->add('success', __('timerizable.time_interval_updated'));
        $route = '/';
        try{
            $route = route(
                config('timerizable.web.time_intervals_update', 'home'),
                [
                    'timeblock' => $timeblock->id,
                    'timeblock_object' => $timeblock,
                    'timeinterval' => $timeInterval->id,
                    'timeinterval_object' => $timeInterval,
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
     * @param  \Therilion\Timerizable\Model\TimeInterval  $timeInterval
     * @return \Illuminate\Http\Response
     */

    public function destroy(MessageBag $messages, TimeBlock $timeblock, TimeInterval $timeInterval)
    {
        $timeInterval->delete();
        $messages->add('success', __('timerizable.time_interval_deleted'));
        $route = '/';
        try{
            $route = route(
                config('timerizable.web.time_intervals_store', 'home'),
                [
                    'timeblock' => $timeblock->id,
                    'timeblock_object' => $timeblock,
                ]
            );
        } catch(\Exception $ex) {
            $messages->add('errors', __('timerizable.route_error', ['place' => get_class($this) . '@store']));
            $messages->add('errors', $ex->getMessage());
        }
        return redirect($route)->with('messages', $messages);
    }
}
