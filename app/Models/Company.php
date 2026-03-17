<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'logo',
        'cover_image',
        'description',
        'website',
        'email',
        'phone',
        'country',
        'city',
        'address',
        'nif',
        'sector',
        'company_type',
        'company_role',
        'plan_id',
        'plan_expires_at',
        'is_verified',
        'is_active',
    ];

    protected $casts = [
        'plan_expires_at' => 'datetime',
        'is_verified'     => 'boolean',
        'is_active'       => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function contests(): HasMany
    {
        return $this->hasMany(Contest::class);
    }

    public function isBuyer(): bool
    {
        return in_array($this->company_role, ['buyer', 'both']);
    }

    public function isSupplier(): bool
    {
        return in_array($this->company_role, ['supplier', 'both']);
    }

    public function hasActivePlan(): bool
    {
        return $this->plan_expires_at !== null && $this->plan_expires_at->gt(now());
    }

    public function scopeVerified(Builder $query): Builder
    {
        return $query->where('is_verified', true);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
