<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContestApplication extends Model
{
    protected $fillable = [
        'contest_id',
        'user_id',
        'cover_letter',
        'solution_description',
        'proposed_value',
        'currency',
        'cv_path',
        'status',
        'notes',
    ];

    protected $casts = [
        'proposed_value' => 'decimal:2',
    ];

    public function contest(): BelongsTo
    {
        return $this->belongsTo(Contest::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ApplicationDocument::class, 'application_id');
    }
}
