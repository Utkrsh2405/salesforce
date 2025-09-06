<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'legal_name',
        'website',
        'phone',
        'fax',
        'email',
        'industry_id',
        'company_size',
        'annual_revenue',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'country',
        'postal_code',
        'billing_address',
        'logo',
        'description',
        'social_media_links',
        'assigned_user_id',
        'source_id',
        'tags',
        'custom_fields',
        'is_client'
    ];

    protected $casts = [
        'billing_address' => 'array',
        'social_media_links' => 'array',
        'tags' => 'array',
        'custom_fields' => 'array',
        'is_client' => 'boolean',
        'annual_revenue' => 'decimal:2'
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function deals()
    {
        return $this->hasMany(Deal::class);
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function source()
    {
        return $this->belongsTo(LeadSource::class, 'source_id');
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'related_to');
    }
}
