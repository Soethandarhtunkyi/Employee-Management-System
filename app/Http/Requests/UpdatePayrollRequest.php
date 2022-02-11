<?php

namespace App\Http\Requests;

use App\Rules\BasicSalary;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePayrollRequest extends FormRequest
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
}
