<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = 'services';
    // protected $id = 'id';
    // protected $category_id = 'category_id';

    // public $name = 'name';
    // public $desc = 'description';
    // public $description = 'description';
    // public $available_from = 'available_from';
    // public $available_to = 'available_to';
    // public $price = 'price';


    // const CREATED_AT = 'created_at';
    // const UPDATED_AT = 'updated_at';
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
