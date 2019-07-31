<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'name', 'establish_date', 'npwp', 'partnership_type_id',
        'business_entity_form', 'company_status', 'address',
        'country_id', 'province_id', 'city_id', 'kecamatan_id',
        'kelurahan_id', 'postcode', 'phone', 'fax', 'email',
        'website', 'contact_person_name', 'contact_person_phone',
        'contact_person_email'
    ];
}
