<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'title',
        'content',
        'title_english',
        'content_english',
        'sort_order',
        'is_active'
    ];
}
