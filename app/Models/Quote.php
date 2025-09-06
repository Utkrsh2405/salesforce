<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quote_number',
        'company_id',
        'contact_id',
        'deal_id',
        'created_by_user_id',
        'quote_date',
        'valid_until',
        'status',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'terms_conditions',
        'notes',
        'signed_at',
        'signature_data'
    ];

    protected $casts = [
        'quote_date' => 'date',
        'valid_until' => 'date',
        'signed_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function items()
    {
        return $this->hasMany(QuoteItem::class);
    }

    public function isExpired()
    {
        return $this->valid_until < now()->toDateString();
    }

    public static function generateQuoteNumber()
    {
        $lastQuote = static::latest('id')->first();
        $number = $lastQuote ? (int) substr($lastQuote->quote_number, 2) + 1 : 1;
        return 'Q-' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }
}
