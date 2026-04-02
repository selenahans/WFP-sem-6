<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Doctor extends Model
{
    use HasFactory;

    protected $table = 'doctors';
    protected $fillable = [
        'name',
        'specialist',
        'license_number',
        'phone_number',
        'bio',
        'photo',
        'experience_years',
        'is_active',
    ];

    protected $casts = [
        'experience_years' => 'integer',
        'is_active' => 'boolean',
        'deleted_at' => 'datetime',
    ];
}