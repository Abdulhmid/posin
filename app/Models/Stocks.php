<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stocks extends Model
{
    protected $table = 'item_stocks';
    protected $guarded = ['id'];
    protected $primaryKey = "id";  

    public function product() {
        return $this->hasOne('App\Models\Products', 'id', 'id_item');
    }  
}
