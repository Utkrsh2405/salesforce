<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'company_id',
        'contact_id',
        'assigned_user_id',
        'deal_stage_id',
        'deal_value',
        'probability',
        'expected_close_date',
        'actual_close_date',
        'deal_source_id',
        'competitor_info',
        'description',
        'products',
        'discount_percentage',
        'tax_amount',
        'total_amount',
        'is_won',
        'lost_reason',
        'tags',
        'custom_fields'
    ];

    protected $casts = [
        'products' => 'array',
        'tags' => 'array',
        'custom_fields' => 'array',
        'is_won' => 'boolean',
        'deal_value' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'probability' => 'integer',
        'expected_close_date' => 'date',
        'actual_close_date' => 'date'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function stage()
    {
        return $this->belongsTo(DealStage::class, 'deal_stage_id');
    }

    public function source()
    {
        return $this->belongsTo(DealSource::class, 'deal_source_id');
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'related_to');
    }
}space App\Models;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    //
}
