<?php 

namespace App\DataTables;

use App\Models\Products_stock;

class ReportsItemBuyDataTables
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
        $this->row = $this->model->select('*');
    }

    public function make()
    {
        $table = \Datatables::of($this->row);

        $collectData = collect();

        $query=$this->model->select('*')->get();
        foreach ($query as $key => $value) {
            $check = Products_stock::where('id_item',$value->id)->sum('stok');
            if ($check) {
                if ($check<1) {
                    $collectData->push([
                        'item' => $value->name,
                        'stock' => 0
                    ]);
                }
            }else{
                $collectData->push([
                    'item' => $value->name,
                    'stock' => 0
                ]);
            }
        }

        return \Datatables::of($collectData)->make();
    }
}