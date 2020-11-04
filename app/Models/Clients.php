<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model {

    protected $table = 'clients';
    protected $guarded = ['id'];
    protected $primaryKey = "id";   

    /**
     * Rules
     *
     * @var array
     */
    public static $rules = [
        'handphone' => 'required',
        'telp' => 'required',
        'city_id' => 'required',
        'address' => 'required'
    ];
}

