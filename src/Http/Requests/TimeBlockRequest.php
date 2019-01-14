<?php

namespace Therilion\Timerizable\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimeBlockRequest extends FormRequest
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
        $id = $this->time_block ? $this->time_block->id : '';
        return [
            'name' => 'required|max:255|unique:' . config('timerizable.time_blocks_database', 'time_blocks_database') . ',name,' . $id,
        ];
    }
}
