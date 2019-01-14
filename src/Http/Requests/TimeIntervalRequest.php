<?php

namespace Therilion\Timerizable\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimeIntervalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'starts_at' => 'required|date_format:"H:i"',
            'ends_at'   => 'required|date_format:"H:i"|after:starts_at',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if(!$this->starts_at || !$this->ends_at){
                return;
            }
            $time_start = explode(':', $this->starts_at);
            $time_end = explode(':', $this->ends_at);
            $starts = \Carbon\Carbon::create(1000, 1, 1, $time_start[0], $time_start[1]);
            $ends = \Carbon\Carbon::create(1000, 1, 1, $time_end[0], $time_end[1]);
            
            foreach($this->time_block->time_intervals as $interval) {
                if($this->time_interval && $this->time_interval->id == $interval->id) {
                    continue;
                }

                if($starts->between($interval->carbon_starts_at, $interval->carbon_ends_at)){
                    $validator->errors()->add('starts_at', __('timerizable::timerizable.time_interval_starts_at_overlap'));
                    break;
                }

                if($ends->between($interval->carbon_starts_at, $interval->carbon_ends_at)) {
                    $validator->errors()->add('ends_at', __('timerizable::timerizable.time_interval_ends_at_overlap'));
                    break;
                }
                if($interval->carbon_starts_at->between($starts, $ends) || $interval->carbon_ends_at->between($starts, $ends)) {
                    $validator->errors()->add('overlaps', __('timerizable::timerizable.time_interval_all_overlap'));
                    break;
                }
            }
        });
    }
}
