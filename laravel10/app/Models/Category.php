<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $id = 'id';

    public $description = 'description';
    public $category_name = 'category_name';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    // protected $fillable = [
    //     'category_name',
    //     'description',
    // ];
}
