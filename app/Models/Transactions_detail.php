<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions_detail extends Model
{
    protected $table = 'transactions_detail';
    protected $guarded = ['id'];
    protected $primaryKey = "id";   

    public function item() {
        return $this->hasOne('App\Models\Products', 'id', 'id_item')->with('pricelist');
    }  
}
