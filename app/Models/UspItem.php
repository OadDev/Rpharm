<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UspItem extends Model
{
    use HasFactory;

    protected $fillable = ['icon_key', 'title', 'description', 'sort_order'];
}
