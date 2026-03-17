<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContestInterest extends Model
{
    protected $fillable = [
        'contest_id',
        'user_id',
        'name',
        'email',
        'phone',
        'professional_area',
        'cv_path',
        'message',
        'status',
    ];

    public function contest(): BelongsTo
    {
        return $this->belongsTo(Contest::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
