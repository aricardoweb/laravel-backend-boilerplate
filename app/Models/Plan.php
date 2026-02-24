<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug_id',
        'name',
        'price',
        'credit_validity',
        'credit_validity_months',
        'features',
        'recommended',
        'is_active',
    ];

    protected $casts = [
        'price' => 'float',
        'credit_validity_months' => 'integer',
        'features' => 'array',
        'recommended' => 'boolean',
        'is_active' => 'boolean',
    ];
}
