<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InProducts extends Model
{
    protected $table = 'item_in';
    protected $guarded = ['id'];
    protected $primaryKey = "id";   

    public static $rules = [
        'id_supplier' => 'required',
        'id_item' => 'required',
        'id_outlet' => 'required',
        'total' => 'required',
        'description' => 'required'
    ];

    public function supplier() {
        return $this->hasOne('App\Models\Suppliers', 'id', 'id_supplier');
    }

    public function outlet() {
        return $this->hasOne('App\Models\Outlets', 'id', 'id_outlet');
    }

    public function product() {
        return $this->hasOne('App\Models\Products', 'id', 'id_item');
    }
}
