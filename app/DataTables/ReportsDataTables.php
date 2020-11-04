<?php 

namespace App\DataTables;

use App\Models\Category;

class ReportsDataTables
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
        $this->row = $this->model
                ->select(\DB::raw('max(created_at)'),\DB::raw('sum(amount)'))
                ->groupBy(\DB::raw('date(created_at)'));
    }

    public function make()
    {
        $table = \Datatables::of($this->row);


        // $table->editColumn('location_id', function ($row) {
        //             return $row->location->name;
        //         });

        // return $table->make();

        $collectData = collect();
        $year = $this->request['year'];
        if ($this->request['filter_by']=="yearly") {
            for ($i=1; $i <=12 ; $i++) {
                $monthFind = sprintf("%02d", $i);
                $income = $this->model
                        ->whereRaw("EXTRACT(MONTH FROM created_at) = '{$i}'")
                        ->whereRaw("EXTRACT(YEAR FROM created_at) = '{$year}'")
                        ->groupBy(\DB::raw('date(created_at)'))
                        ->sum('amount');
                $collectData->push([
                    'data'  => date('F', mktime(0, 0, 0, $monthFind, 10)),
                    'total' => (int)$income
                ]);
            }
        }else{
            $loopData = \GlobalHelper::calDayInMonth(
                                        $this->request['bulYear'], 
                                        $this->request['bulMonth']
                                );
            for ($i=1; $i <= $loopData ; $i++) {
                $yearF = $this->request['bulYear'];
                $monthF = $this->request['bulMonth'];
                $income = $this->model
                        ->whereRaw("EXTRACT(YEAR FROM created_at) = '{$yearF}'")
                        ->whereRaw("EXTRACT(MONTH FROM created_at) = '{$monthF}'")
                        ->whereRaw("EXTRACT(DAY FROM created_at) = '{$i}'")
                        ->groupBy(\DB::raw('date(created_at)'))
                        ->sum('amount');
                $collectData->push([
                    'data'  => $i,
                    'total' => (int)$income
                ]);
            }
        }

        return \Datatables::of($collectData)->make();
    }
}