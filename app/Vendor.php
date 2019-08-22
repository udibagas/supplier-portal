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
        'contact_person_email', 'user_id', 'account_group_id',
        'industry_type', 'product_type', 'verification_status'
    ];

    protected $with = [
        'banks', 'documents', 'managements',
        'user', 'partnership_type', 'account_group',
        'reviews'
    ];

    protected $casts = [
        'industry_type' => 'array',
        'product_type' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function partnership_type() {
        return $this->belongsTo(PartnershipType::class);
    }

    public function account_group() {
        return $this->belongsTo(AccountGroup::class);
    }

    public function banks() {
        return $this->hasMany(VendorBank::class);
    }

    public function documents() {
        return $this->hasMany(VendorDocument::class);
    }

    public function managements() {
        return $this->hasMany(VendorCompanyManagement::class);
    }

    public function reviews() {
        return $this->hasMany(VendorRegistrationReview::class);
    }
}
