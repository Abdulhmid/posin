<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles_client extends Model {

    protected $table = 'roles_client';
    protected $guarded = ['id'];
    protected $primaryKey = "id";   

    public function role() {
        return $this->hasOne('App\Models\Roles', 'id', 'id_role');
    }
}

