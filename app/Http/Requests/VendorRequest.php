<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
            'establish_date' => 'required|date',
            'npwp' => 'required',
            'partnership_type_id' => 'required|exists:partnership_types,id',
            // 'business_entity_form' => 'required',
            'company_status' => 'required',
            'address' => 'required',
            // 'country_id' => 'required',
            // 'province_id' => 'required',
            // 'city_id' => 'required',
            // 'kecamatan_id' => 'required',
            // 'kelurahan_id' => 'required',
            'postcode' => 'required',
            'phone' => 'required',
            'fax' => 'required',
            'email' => 'required|email',
            'website' => 'required|url',
            'contact_person_name' => 'required',
            'contact_person_phone' => 'required',
            'contact_person_email' => 'required|email'
        ];
    }
}
