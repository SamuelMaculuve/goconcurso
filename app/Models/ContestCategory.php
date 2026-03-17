<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContestCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'description',
        'color',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function contests(): HasMany
    {
        return $this->hasMany(Contest::class, 'category_id');
    }
}
