<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    use HasFactory;


    protected $fillable = [
        'address_hu',
        'address_en',
        'phone',
        'email',
        'facebook',
        'instagram',
        'linkedin'
    ];
}
