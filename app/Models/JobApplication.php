<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_opening_id', 'full_name', 'email', 'phone', 'position',
        'cover_note', 'cv_path', 'cv_original_name', 'status',
    ];

    public function jobOpening(): BelongsTo
    {
        return $this->belongsTo(JobOpening::class);
    }
}
