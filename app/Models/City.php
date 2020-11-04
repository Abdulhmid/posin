<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    protected $table      = 'cities';
    protected $primaryKey = 'city_id';
    protected $guarded    = ['city_id'];

    // public function state() {
    //     return $this->belongsTo('App\Models\States', 'state_id', 'state_id');
    // }
}
