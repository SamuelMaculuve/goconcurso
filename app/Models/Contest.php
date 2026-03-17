<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contest extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'deadline'    => 'datetime',
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ContestCategory::class, 'category_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ContestDocument::class);
    }

    public function interests(): HasMany
    {
        return $this->hasMany(ContestInterest::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(ContestApplication::class);
    }

    public function savedByUsers(): HasMany
    {
        return $this->hasMany(SavedContest::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(ContestView::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeByType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    public function scopeByCategory(Builder $query, int|string $category): Builder
    {
        return $query->where('category_id', $category);
    }

    public function scopeByCountry(Builder $query, string $country): Builder
    {
        return $query->where('country', $country);
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }
}
