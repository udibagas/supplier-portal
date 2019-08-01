<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuotationRequest extends FormRequest
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
            'quotation_request_id' => 'required|exists:quotation_requests,id',
            'vendor_id' => 'required|exists:vendors,id',
            'quotation_number' => 'required',
            'currency' => 'required',
            'term_of_payment' => 'required',
            'inco_term' => 'required',
        ];
    }
}
