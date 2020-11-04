<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Products extends Model
{
    use SearchableTrait;

    protected $table = 'items';
    protected $guarded = ['id'];
    protected $primaryKey = "id"; 

    protected $searchable = [
        'columns' => [
            'items.name' => 10,
            'item_price.selling_price' => 10
        ],
        'joins' => [
            'item_price' => ['items.id','item_price.id_item'],
        ],
    ]; 

    public function supplier() {
        return $this->hasOne('App\Models\Suppliers', 'id', 'id_supplier');
    } 

    public function categories() {
        return $this->hasOne('App\Models\Category', 'id', 'id_category');
    }

    public function pricelist() {
        return $this->hasOne('App\Models\Products_price', 'id_item', 'id');
    } 

    public function stock() {
        return $this->hasOne('App\Models\Products_stock', 'id_item', 'id');
    } 

    public function item_price() {
        return $this->hasOne('App\Models\Products_price', 'id', 'id_item');
    } 

    public static $rules = [
        'id_category'   => 'required',
        'id_supplier' 	=> 'required',
        'name' 			=> 'required',
        'description' 		=> 'required',
        'purchase_price' 	=> 'required',
        'selling_price' 	=> 'required'
    ];
}
