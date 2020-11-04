<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'item_category';
    protected $guarded = ['id'];
    protected $primaryKey = "id";   

    public static $rules = [
        'name' => 'required',
        'description' => 'required'
    ];
}
