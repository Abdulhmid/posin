<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = 'transactions';
    protected $guarded = ['id'];
    protected $primaryKey = "id";   

    public function detail() {
        return $this->hasMany('App\Models\Transactions_detail', 'id_trans', 'id_trans')
        		->with('item');
    }  
}
