<?php

namespace App\Http\Requests;

use App\Rules\BasicSalary;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
                'unique:employees,email',
                'max:100'
            ],
            'password' => ['required',
                'min:6',
                'max:20',
                'confirmed'
            ],
            'phone' => [
                'required',
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                'min:10',
                'max:15',
                'ends_with:0,1,2,3,4,5,6,7,8,9',
                new PhoneNumber
            ],
            'address' => ['required', 'max:255'],
            'profile' => ['required', 'mimes:png,jpg,jpeg,svg', 'max:2000'],
            'role_id' => ['required', 'max:100'],
            'department_id' => ['required', 'max:100'],
            'leave_fine' => [
                'required',
                'min:4',
                'max:20',
                new BasicSalary
            ],
            'overtime_fee' => [
                'required',
                'min:4',
                'max:20',
                new BasicSalary
            ],
            'basic_salary' => [
                'required',
                'min:4',
                'max:20',
                new BasicSalary
            ]
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
