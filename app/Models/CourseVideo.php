<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseVideo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'original_filename',
        'stored_filename',
        'file_path',
        'mime_type',
        'file_size',
        'is_downloadable',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_downloadable' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get full path to video file
     *
     * @return string
     */
    public function getFullPathAttribute()
    {
        return $this->file_path . '/' . $this->stored_filename;
    }
}
