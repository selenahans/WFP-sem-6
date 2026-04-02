<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'author_id',
        'status',
        'view_count',
    ];

    protected $casts = [
        'view_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function author(): BelongsTo
    {

        return $this->belongsTo(User::class, 'author_id');
    }


    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}