<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailCampaign extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'subject',
        'template_id',
        'sender_name',
        'sender_email',
        'reply_to_email',
        'content',
        'status',
        'scheduled_at',
        'sent_at',
        'recipient_count',
        'delivered_count',
        'opened_count',
        'clicked_count',
        'bounced_count',
        'unsubscribed_count',
        'segment_criteria',
        'a_b_test_config',
        'created_by_user_id'
    ];

    protected $casts = [
        'segment_criteria' => 'array',
        'a_b_test_config' => 'array',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'recipient_count' => 'integer',
        'delivered_count' => 'integer',
        'opened_count' => 'integer',
        'clicked_count' => 'integer',
        'bounced_count' => 'integer',
        'unsubscribed_count' => 'integer'
    ];

    public function template()
    {
        return $this->belongsTo(EmailTemplate::class);
    }

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }
}
