<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_name',
        'contact_name',
        'email',
        'phone',
        'job_title',
        'lead_source_id',
        'lead_status_id',
        'assigned_user_id',
        'estimated_value',
        'probability',
        'expected_close_date',
        'industry_id',
        'company_size',
        'budget_range',
        'pain_points',
        'decision_makers',
        'communication_history',
        'lead_score',
        'conversion_date',
        'tags',
        'custom_fields'
    ];

    protected $casts = [
        'decision_makers' => 'array',
        'communication_history' => 'array',
        'tags' => 'array',
        'custom_fields' => 'array',
        'estimated_value' => 'decimal:2',
        'probability' => 'integer',
        'lead_score' => 'integer',
        'expected_close_date' => 'date',
        'conversion_date' => 'datetime'
    ];

    public function source()
    {
        return $this->belongsTo(LeadSource::class, 'lead_source_id');
    }

    public function status()
    {
        return $this->belongsTo(LeadStatus::class, 'lead_status_id');
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'related_to');
    }

    public function convertToDeal()
    {
        // Create a new company
        $company = Company::create([
            'name' => $this->company_name,
            'industry_id' => $this->industry_id,
            'company_size' => $this->company_size,
            'phone' => $this->phone,
            'source_id' => $this->lead_source_id,
            'assigned_user_id' => $this->assigned_user_id
        ]);

        // Create a new contact
        $contact = $company->contacts()->create([
            'first_name' => explode(' ', $this->contact_name)[0],
            'last_name' => explode(' ', $this->contact_name)[1] ?? '',
            'email' => $this->email,
            'phone' => $this->phone,
            'job_title' => $this->job_title,
            'assigned_user_id' => $this->assigned_user_id,
            'is_primary_contact' => true
        ]);

        // Create a new deal
        $deal = Deal::create([
            'title' => "Deal with {$this->company_name}",
            'company_id' => $company->id,
            'contact_id' => $contact->id,
            'assigned_user_id' => $this->assigned_user_id,
            'deal_value' => $this->estimated_value,
            'probability' => $this->probability,
            'expected_close_date' => $this->expected_close_date
        ]);

        // Update lead conversion date
        $this->update(['conversion_date' => now()]);

        return $deal;
    }
}
