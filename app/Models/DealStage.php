<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealStage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'probability',
        'order',
        'color',
        'is_active'
    ];

    protected $casts = [
        'probability' => 'integer',
        'order' => 'integer',
        'is_active' => 'boolean'
    ];

    public function deals()
    {
        return $this->hasMany(Deal::class);
    }
}
