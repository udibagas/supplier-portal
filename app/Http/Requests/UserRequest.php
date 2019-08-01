<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'sometimes|required|min:6',
            'active' => 'boolean',
            'role' => 'required',
            'vendor_id' => 'exists:vendor,id',
            'department_id' => 'exists.departments,id'
        ];
    }
}
