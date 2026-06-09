<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'services';

    protected $fillable = [
        'name',
        'description',
        'available_from',
        'available_to',
        'category_id',
        'price'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')
            ->withTrashed();
    }
}
