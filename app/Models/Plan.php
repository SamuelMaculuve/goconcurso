<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'billing_cycle',
        'max_contests',
        'features',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'features'    => 'array',
        'price'       => 'decimal:2',
        'max_contests' => 'integer',
        'is_active'   => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }
}
