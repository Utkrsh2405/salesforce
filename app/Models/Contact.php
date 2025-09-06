<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'first_name',
        'last_name',
        'job_title',
        'department',
        'email',
        'phone',
        'mobile',
        'direct_phone',
        'assistant_name',
        'assistant_phone',
        'birthdate',
        'address',
        'social_profiles',
        'communication_preferences',
        'assigned_user_id',
        'is_primary_contact',
        'lead_score',
        'tags',
        'custom_fields'
    ];

    protected $casts = [
        'address' => 'array',
        'social_profiles' => 'array',
        'communication_preferences' => 'array',
        'tags' => 'array',
        'custom_fields' => 'array',
        'is_primary_contact' => 'boolean',
        'lead_score' => 'integer',
        'birthdate' => 'date'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function deals()
    {
        return $this->hasMany(Deal::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'related_to');
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}space App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //
}
