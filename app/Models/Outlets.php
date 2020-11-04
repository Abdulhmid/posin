<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outlets extends Model {

    protected $table = 'outlets';
    protected $guarded = ['id'];
    protected $primaryKey = "id";   

    public static $rules = [
        'name' => 'required',
        'email' => 'required',
        'handphone' => 'required',
        'telp' => 'required',
        'city_id' => 'required',
        // 'id_client' => 'required',
        'address' => 'required',
        'description' => 'required'
    ];
}

