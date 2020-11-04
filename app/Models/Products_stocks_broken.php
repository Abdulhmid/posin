<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Outlets;

class Products_stocks_broken extends Model
{
    protected $table = 'item_stocks_broken';
    protected $guarded = ['id'];
    protected $primaryKey = "id";  

    public static function boot()
    {
    	$outlet = Outlets::first()->id;
        parent::boot();

        self::creating(function ($item) {
            return $item->id_outlet =1;
        });
    }

    public function product() {
        return $this->hasOne('App\Models\Products', 'id', 'id_item');
    }  
}
