<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model {

    protected $table = 'users';
    protected $guarded = ['id'];
    protected $primaryKey = "id";   

    public function role_client() {
        return $this->hasOne('App\Models\Roles_client', 'id', 'id_role');
    }

    public function outlet() {
        return $this->hasOne('App\Models\Outlets', 'id', 'id_outlet');
    }

    public static $rules = [
        'username' => 'required',
        'id_role' => 'required',
        'id_outlet' => 'required',
        'address' => 'required'
    ];
}

