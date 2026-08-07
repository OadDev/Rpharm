<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'title', 'quote', 'avatar_url', 'show_on_home', 'show_on_about', 'sort_order',
    ];

    protected $casts = [
        'show_on_home' => 'boolean',
        'show_on_about' => 'boolean',
    ];
}
