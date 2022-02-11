<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleRequest extends FormRequest
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
            'name' => ['required', 'max:100'],
            'description' => ['required', 'max:255'],
            'start_date' => ['required', 'after:yesterday'],
            'end_date' => ['required', 'after_or_equal:start_date'],
            'assigne_id' => ['required', 'max:100'],
            'file' => ['required', 'mimes:png,jpg,xlsx,csv,doc', 'max:2000']
        ];
    }
}
