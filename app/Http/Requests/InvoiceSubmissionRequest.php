<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceSubmissionRequest extends FormRequest
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
            // 'vendor_id' => 'required|exists:vendors,id',
            'invoice_date' => 'required|date',
            'invoice_number' => 'required',
            'faktur_number' => 'required',
            'faktur_date' => 'required|date',
            'payment_term_id' => 'required|exists:payment_terms,id',
            'due_date' => 'required|date',
            'status' => 'required|numeric',
            'wht_type_id' => 'required',
            'wht_code_id' => 'required|exists:wht_code,id',
            'wht_base_amount' => 'required|numeric',
            'wht_amount' => 'required|numeric',
            // 'total' => 'numeric'
        ];
    }
}
