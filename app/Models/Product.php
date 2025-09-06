<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'unit_price',
        'cost_price',
        'category',
        'sku',
        'stock_quantity',
        'tax_rate',
        'is_active',
        'custom_fields'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'is_active' => 'boolean',
        'tax_rate' => 'integer',
        'stock_quantity' => 'integer'
    ];

    public function quoteItems()
    {
        return $this->hasMany(QuoteItem::class);
    }
}
