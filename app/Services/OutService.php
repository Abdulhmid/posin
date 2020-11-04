<?php

namespace App\Services;

use DB;
use Auth;
use Config;
use Exception;
use App\Models\OutProducts;
use App\Models as Md;
use Illuminate\Support\Facades\Schema;

class OutService
{
    public function __construct(
        OutProducts $model,
        Md\Products $products,
        Md\Products_stock $products_stocks,
        Md\Products_stocks_broken $products_stocks_broken
    ) {
        $this->model = $model;
        $this->products = $products;
        $this->products_stocks = $products_stocks;
        $this->products_stocks_broken = $products_stocks_broken;
    }

    /*
    |--------------------------------------------------------------------------
    | Getters
    |--------------------------------------------------------------------------
    */


    /**
     * All clients
     * @return \Illuminate\Support\Collection|null|static|Role
     */
    public function all()
    {
        return $this->model->all();
    }

    /*
    |--------------------------------------------------------------------------
    | Setters
    |--------------------------------------------------------------------------
    */

    /**
     * Create a role
     *
     * @param  array $input
     * @return Role
     */
    public function create($input)
    {
        try {
            $row = $this->model->create($input);
            $this->updateStock($row);
            return $row;
        } catch (Exception $e) {
            throw new Exception("Failed to create role", 1);
        }
    }

    /**
     * Update a role
     *
     * @param  int $id
     * @param  array $input
     * @return boolean
     */
    public function update($id, $input)
    {
        $role = $this->model->find($id);
        $role->update($input);
        $this->updateStock($role);

        return $role;
    }

    private function updateStock($row){
        $item = $this->products_stocks->where('id_item',$row->id_item)->first();
        if ($item) {
           $this->products_stocks->where('id_item',$row->id_item)
            ->update([
                'stok' => $item->stok+$row->total
            ]);
        }else{
           $this->products_stocks->create([
                'id_item' => $row->id_item,
                'id_outlet' => $row->id_outlet,
                'stok' => $row->total
            ]);
        }
    }

    private function updateStockBroken($row){
        $item = $this->products_stocks->where('id_item',$row->id_item)->first();
        if ($item) {
           $this->products_stocks->where('id_item',$row->id_item)
            ->update([
                'stok' => $item->stok+$row->total
            ]);
        }else{
           $this->products_stocks->create([
                'id_item' => $row->id_item,
                'id_outlet' => $row->id_outlet,
                'stok' => $row->total
            ]);
        }
    }
}
