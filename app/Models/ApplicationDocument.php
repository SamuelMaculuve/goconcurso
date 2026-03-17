<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationDocument extends Model
{
    protected $fillable = [
        'application_id',
        'name',
        'file_path',
        'file_type',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(ContestApplication::class, 'application_id');
    }
}
