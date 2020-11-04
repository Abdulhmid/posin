<?php 

namespace App\DataTables;

use App\Models\Category;
use App\Models\Products;

class ReportsItemInDataTables
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

        $listProduct=Products::select('*')->get();
        $collectData = collect();
        $year = $this->request['year'];
        if ($this->request['filter_by']=="yearly") {
            foreach ($listProduct as $keyP => $valueP) {
                $arrayTemp=[];
                for ($i=1; $i <=12 ; $i++) {
                    $monthFind = sprintf("%02d", $i);
                    $total = $this->model
                            ->where('id_item',$valueP->id)
                            ->whereRaw("EXTRACT(MONTH FROM created_at) = '{$i}'")
                            ->whereRaw("EXTRACT(YEAR FROM created_at) = '{$year}'")
                            ->groupBy(\DB::raw('date(created_at)'))
                            ->sum('total');
                    $arrayTemp[date('F', mktime(0, 0, 0, $monthFind, 10))]=(int)$total;
                }
                $string='';
                foreach ($arrayTemp as $keyTemp => $valueTemp) {
                    $string.="<tr><td>".$keyTemp." ".$this->request['year']."</td><td>:</td><td>".$valueTemp."<td/></tr>";
                }

                $collectData->push([
                    'name'  => $valueP->name,
                    'data'  => "<table>".$string."</table>"
                ]);
            }
        }else{
            $loopData = \GlobalHelper::calDayInMonth(
                                        $this->request['bulYear'], 
                                        $this->request['bulMonth']
                                );
            $monthFind = sprintf("%02d", $this->request['bulMonth']);
            foreach ($listProduct as $keyP => $valueP) {
                $arrayTemp=[];
                for ($i=1; $i <= $loopData ; $i++) {
                    $yearF = $this->request['bulYear'];
                    $monthF = $this->request['bulMonth'];
                    $total = $this->model
                            ->where('id_item',$valueP->id)
                            ->whereRaw("EXTRACT(YEAR FROM created_at) = '{$yearF}'")
                            ->whereRaw("EXTRACT(MONTH FROM created_at) = '{$monthF}'")
                            ->whereRaw("EXTRACT(DAY FROM created_at) = '{$i}'")
                            ->groupBy(\DB::raw('date(created_at)'))
                            ->sum('total');

                    $arrayTemp[$i]=(int)$total;
                }
                $string='';
                foreach ($arrayTemp as $keyTemp => $valueTemp) {
                    $string.="<tr><td> ".$keyTemp." ".date('F', mktime(0, 0, 0, $monthFind, 10))." ".$this->request['bulYear']."</td><td>:</td><td>".$valueTemp."<td/></tr>";
                }

                $collectData->push([
                    'name'  => $valueP->name,
                    'data'  => "<table>".$string."</table>"
                ]);
            }
        }

        return \Datatables::of($collectData)->make();
    }
}