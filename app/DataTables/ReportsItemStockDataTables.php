<?php 

namespace App\DataTables;

use App\Models\Category;
use App\Models\Products;

class ReportsItemStockDataTables
{

    protected $model;
    protected $request;
    public $data;
    public $row;

    public function __construct(
      $model,
      $request
    )
    {
        $this->model        = $model;
        $this->request      = $request;
        $this->getData();
    }

    protected function getData()
    { 
        $this->row = $this->model->with(['product'])->select('*');
    }

    public function make()
    {
        $table = \Datatables::of($this->row);

        $listProduct=Products::select('*')->get();
        $collectData = collect();

        $query=$this->model->with(['product'])->select('*')->get();
        foreach ($listProduct as $key => $value) {
            $collectData->push([
                'item' => $value->name,
                'stock' => $this->model->where('id_item',$value->id)->sum('stok')
            ]);
        }

        return \Datatables::of($collectData)->make();
    }
}