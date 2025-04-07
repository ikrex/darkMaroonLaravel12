<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'birth_details',
        'email',
        'phone',
        'payment_method',
        'love_language_test_file',
        'question1',
        'question2',
        'question3',
        'question4',
        'question5',
        'desire'
    ];
}
