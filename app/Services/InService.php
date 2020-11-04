<?php

namespace App\Services;

use DB;
use Auth;
use Config;
use Exception;
use App\Models\InProducts;
use App\Models as Md;
use Illuminate\Support\Facades\Schema;

class InService
{
    public function __construct(
        InProducts $model,
        Md\Products $products,
        Md\Products_stock $products_stocks
    ) {
        $this->model = $model;
        $this->products = $products;
        $this->products_stocks = $products_stocks;
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

    /**
     * Paginated clients
     * @return \Illuminate\Support\Collection|null|static|Role
     */
    public function paginated()
    {
        return $this->model->paginate(env('paginate', 25));
    }

    /**
     * Find a role
     * @param  integer $id
     * @return \Illuminate\Support\Collection|null|static|Role
     */
    public function find($id)
    {
        return $this->model->find($id);
    }


    /**
     * Search the clients
     * @param  string $input
     * @return \Illuminate\Support\Collection|null|static|Role
     */
    public function search($input)
    {
        $query = $this->model->orderBy('name', 'desc');

        $columns = Schema::getColumnListing('clients');

        foreach ($columns as $attribute) {
            $query->orWhere($attribute, 'LIKE', '%'.$input.'%');
        };

        return $query->paginate(env('paginate', 25));
    }

    /**
     * Find Role by name
     *
     * @param string $name
     *
     * @return \Illuminate\Support\Collection|null|static|Role
     */
    public function findByName($name)
    {
        return $this->model->where('name', $name)->firstOrFail();
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

    /**
     * Destroy the role
     *
     * @param  int $id
     * @return bool
     */
    public function destroy($id)
    {
        try {
            $result = $this->model->find($id)->delete();

            return $result;
        } catch (Exception $e) {
            throw new Exception("We were unable to delete this role", 1);
        }

        return $result;
    }
}
