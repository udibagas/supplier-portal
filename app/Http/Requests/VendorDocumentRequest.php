<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorDocumentRequest extends FormRequest
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
            'vendor_id' => 'required|exists:vendors,id',
            'name' => 'required',
            'file_path' => 'required',
            'expiry_date' => 'required|date'
        ];
    }
}
