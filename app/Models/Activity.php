<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'subject',
        'description',
        'due_date',
        'due_time',
        'duration_minutes',
        'related_to_type',
        'related_to_id',
        'assigned_user_id',
        'completed_by_user_id',
        'is_completed',
        'completed_at',
        'priority',
        'location',
        'attendees',
        'outcome',
        'next_action',
        'is_billable',
        'billable_hours'
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'due_time' => 'datetime',
        'completed_at' => 'datetime',
        'attendees' => 'array',
        'is_completed' => 'boolean',
        'is_billable' => 'boolean',
        'billable_hours' => 'decimal:2',
        'duration_minutes' => 'integer'
    ];

    public function relatedTo()
    {
        return $this->morphTo();
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function completedByUser()
    {
        return $this->belongsTo(User::class, 'completed_by_user_id');
    }
}