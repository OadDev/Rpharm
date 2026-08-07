<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobOpening extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'department', 'location', 'employment_type', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }
}
