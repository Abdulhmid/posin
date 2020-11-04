<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions_return extends Model
{
    protected $table = 'transactions_return';
    protected $guarded = ['id'];
    protected $primaryKey = "id";   

    public function item() {
        return $this->hasOne('App\Models\Products', 'id', 'id_item')->with('pricelist');
    }  
}
