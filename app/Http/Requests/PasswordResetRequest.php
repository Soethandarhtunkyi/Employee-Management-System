<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordResetRequest extends FormRequest
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
            'email' => ['required',
                'email',
                'exists:employees,email,deleted_at,NULL'
            ],
            'password' => ['required',
                'string',
                'min:6',
                'max:20',
                'confirmed'
            ],
            'password_confirmation' => ['required']
        ];
    }
}
