<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    protected $table = 'suppliers';
    protected $guarded = ['id'];
    protected $primaryKey = "id";  

    public static $rules = [
        'name' => 'required',
        'handphone' => 'required',
        'telp' => 'required',
        'address' => 'required',
        'city_id' => 'required',
        'description' => 'required'
    ];
}
