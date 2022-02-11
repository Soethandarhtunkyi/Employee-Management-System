<?php

namespace App\Http\Requests;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class EditEmployeeRequest extends FormRequest
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
            'email' => ['required',
                'email',
                'unique:employees,email,' . $this->id,
                'max:100'
            ],
            'phone' => [
                'required',
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                'min:10',
                'max:15',
                'ends_with:0,1,2,3,4,5,6,7,8,9',
                new PhoneNumber
            ],
            'address' => ['required', 'max:200'],
            'role_id' => ['required', 'max:100'],
            'department_id' => ['required', 'max:100'],
            'profile' => ['mimes:png,jpg,jpeg,svg', 'max:2000']
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'phone.regex' => 'Please enter real phone number',
            'name.required' => 'The name field is required'
        ];
    }
}
