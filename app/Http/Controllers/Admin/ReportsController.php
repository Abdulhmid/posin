<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\ReportsDataTables;
use App\DataTables\ReportsItemInDataTables;
use App\DataTables\ReportsItemStockDataTables;
use App\DataTables\ReportsItemBuyDataTables;
use App\DataTables\ReportsReturnDataTables;
use App\Models\Transactions;
use App\Models\Transactions_detail;
use App\Models\Transactions_return;
use App\Models\InProducts;
use App\Models\Products;
use App\Models\Products_stock;

class ReportsController extends Controller
{

    protected $title = "Laporan";
    protected $url = "reports";
    protected $folder = "admin.reports";
    protected $form;

    public function __construct(
        Products $item,
        InProducts $itemIn,
        Products_stock $itemStock,
        Transactions $transactions,
        Transactions_detail $transactions_detail,
        Transactions_return $transactions_return
    )
    {
        $this->transactions_detail = $transactions_detail;
        $this->transactions_return = $transactions_return;
        $this->transactions = $transactions;
        $this->itemIn = $itemIn;
        $this->itemStock = $itemStock;
        $this->item = $item;
    }

    public function index(){
		$data['title'] = $this->title;
        return view($this->folder . '.index',$data);
    }

    public function getDataTable(Request $request){
        return (new ReportsDataTables($this->transactions_detail, $request))->make();
    }

    public function excel(Request $request){
      $collectData = collect();
        $year = $request['year'];
        if ($request['filter_by']=="yearly") {
            for ($i=1; $i <=12 ; $i++) {
                $monthFind = sprintf("%02d", $i);
                $income = $this->transactions_detail
                        ->whereRaw("EXTRACT(MONTH FROM created_at) = '{$i}'")
                        ->whereRaw("EXTRACT(YEAR FROM created_at) = '{$year}'")
                        ->groupBy(\DB::raw('date(created_at)'))
                        ->sum('amount');
                $collectData->push([
                    'data'  => date('F', mktime(0, 0, 0, $monthFind, 10)),
                    'total' => (int)$income
                ]);
            }
            $title = "Tahun ".$request['year'];
            $type = "Tahunan";
        }else{
            $loopData = \GlobalHelper::calDayInMonth(
                                        $request['bulYear'], 
                                        $request['bulMonth']
                                );
            for ($i=1; $i <= $loopData ; $i++) {
                $yearF = $request['bulYear'];
                $monthF = $request['bulMonth'];
                $income = $this->transactions_detail
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
            $title = "Tahun ".$request['bulYear']." Bulan ".$request['bulMonth'];
            $type = "Bulanan";
        }
        $rowData['data']=$collectData;
        $rowData['by']=$title;
        $rowData['type']=$type;
        ob_end_clean();
        return \Excel::create('Import Income ', function($excel) use ($rowData) {
            $excel->sheet('Report Import Income', function($sheet) use ($rowData) {
                $sheet->loadView($this->folder.'.excel',$rowData);
            });
        })->export('xls');
    }

    public function itemIn(){
        $data['title'] = 'Laporan Barang Masuk';
        return view($this->folder . '.itemIn',$data);
    }

    public function getDataTableItemIn(Request $request){
        return (new ReportsItemInDataTables($this->itemIn, $request))->make();
    }

    public function excelIn(Request $request){
        $collectData = collect();
        $year = $request['year'];
        $listProduct=Products::select('*')->get();
        if ($request['filter_by']=="yearly") {
            foreach ($listProduct as $keyP => $valueP) {
                $arrayTemp=[];
                for ($i=1; $i <=12 ; $i++) {
                    $monthFind = sprintf("%02d", $i);
                    $total = $this->itemIn
                            ->where('id_item',$valueP->id)
                            ->whereRaw("EXTRACT(MONTH FROM created_at) = '{$i}'")
                            ->whereRaw("EXTRACT(YEAR FROM created_at) = '{$year}'")
                            ->groupBy(\DB::raw('date(created_at)'))
                            ->sum('total');
                    $arrayTemp[date('F', mktime(0, 0, 0, $monthFind, 10))]=(int)$total;
                }
                $collectData->push([
                    'name' => $valueP->name,
                    'data'  => $arrayTemp
                ]);
            }
            $title = "Tahun ".$request['year'];
            $type = "Tahunan";
        }else{
            $loopData = \GlobalHelper::calDayInMonth(
                                        $request['bulYear'], 
                                        $request['bulMonth']
                                );
            foreach ($listProduct as $keyP => $valueP) {
                $arrayTemp=[];
                for ($i=1; $i <= $loopData ; $i++) {
                    $yearF = $request['bulYear'];
                    $monthF = $request['bulMonth'];
                    $total = $this->itemIn
                            ->where('id_item',$valueP->id)
                            ->whereRaw("EXTRACT(YEAR FROM created_at) = '{$yearF}'")
                            ->whereRaw("EXTRACT(MONTH FROM created_at) = '{$monthF}'")
                            ->whereRaw("EXTRACT(DAY FROM created_at) = '{$i}'")
                            ->groupBy(\DB::raw('date(created_at)'))
                            ->sum('total');
                    $arrayTemp[$i]=(int)$total;
                }
                $collectData->push([
                    'name'  => $valueP->name,
                    'data' => $arrayTemp
                ]);
            }
            $title = "Tahun ".$request['bulYear']." Bulan ".date('F', mktime(0, 0, 0, sprintf("%02d", $request['bulMonth']), 10));
            $type = "Bulanan";
        }

        $rowData['data']=$collectData;
        $rowData['by']=$title;
        $rowData['type']=$type;
        ob_end_clean();
        return \Excel::create('Import Products In ', function($excel) use ($rowData) {

            $excel->sheet('Report Import Products In', function($sheet) use ($rowData) {

                $sheet->loadView($this->folder.'.excelIn',$rowData);

            });

        })->export('xls');


    }

    public function itemStock(){
        $data['title'] = 'Laporan Stok Barang';
        return view($this->folder . '.itemStock',$data);
    }

    public function getDataTableItemStock(Request $request){
        return (new ReportsItemStockDataTables($this->itemStock, $request))->make();
    }

    public function excelStock(Request $request){
        $collectData = collect();

        $listProduct=Products::select('*')->get();
     
        foreach ($listProduct as $keyP => $valueP) {
            $collectData->push([
                'name' => $valueP->name,
                'stock'  => $this->itemStock->where('id_item',$valueP->id)->sum('stok')
            ]);
        }

        $title = "Laporan Stok Barang Tersedia";


        $rowData['data']=$collectData;
        $rowData['by']=\Carbon\Carbon::now()->format('d F Y');

        ob_end_clean();
        return \Excel::create('Import Products Stock ', function($excel) use ($rowData) {

            $excel->sheet('Report Import Products Stock', function($sheet) use ($rowData) {

                $sheet->loadView($this->folder.'.excelStock',$rowData);

            });

        })->export('xls');
    }

    public function itemReturn(){
        $data['title'] = $this->title;
        return view($this->folder . '.itemReturn',$data);
    }

    public function getDataTableReturn(Request $request){
        return (new ReportsReturnDataTables($this->transactions_return, $request))->make();
    }

    public function excelReturn(Request $request){
        $collectData = collect();
        $year = $request['year'];
        $listProduct=Products::select('*')->get();
        if ($request['filter_by']=="yearly") {
            foreach ($listProduct as $keyP => $valueP) {
                $arrayTemp=[];
                for ($i=1; $i <=12 ; $i++) {
                    $monthFind = sprintf("%02d", $i);
                    $totalQty = $this->transactions_return
                            ->where('id_item',$valueP->id)
                            ->whereRaw("EXTRACT(MONTH FROM created_at) = '{$i}'")
                            ->whereRaw("EXTRACT(YEAR FROM created_at) = '{$year}'")
                            ->groupBy(\DB::raw('date(created_at)'))
                            ->sum('qty');
                    $arrayTemp[date('F', mktime(0, 0, 0, $monthFind, 10))]=(int)$totalQty;
                }
                $collectData->push([
                    'name' => $valueP->name,
                    'data'  => $arrayTemp
                ]);
            }
            $title = "Tahun ".$request['year'];
            $type = "Tahunan";
        }else{
            $loopData = \GlobalHelper::calDayInMonth(
                                        $request['bulYear'], 
                                        $request['bulMonth']
                                );
            foreach ($listProduct as $keyP => $valueP) {
                $arrayTemp=[];
                for ($i=1; $i <= $loopData ; $i++) {
                    $yearF = $request['bulYear'];
                    $monthF = $request['bulMonth'];
                    $totalQty = $this->transactions_return
                            ->where('id_item',$valueP->id)
                            ->whereRaw("EXTRACT(YEAR FROM created_at) = '{$yearF}'")
                            ->whereRaw("EXTRACT(MONTH FROM created_at) = '{$monthF}'")
                            ->whereRaw("EXTRACT(DAY FROM created_at) = '{$i}'")
                            ->groupBy(\DB::raw('date(created_at)'))
                            ->sum('qty');
                    $arrayTemp[$i]=(int)$totalQty;
                }
                $collectData->push([
                    'name'  => $valueP->name,
                    'data' => $arrayTemp
                ]);
            }
            $title = "Tahun ".$request['bulYear']." Bulan ".date('F', mktime(0, 0, 0, sprintf("%02d", $request['bulMonth']), 10));
            $type = "Bulanan";
        }

        $rowData['data']=$collectData;
        $rowData['by']=$title;
        $rowData['type']=$type;
        ob_end_clean();
        return \Excel::create('Import Products Return ', function($excel) use ($rowData) {

            $excel->sheet('Report Import Products Return', function($sheet) use ($rowData) {

                $sheet->loadView($this->folder.'.excelReturn',$rowData);

            });

        })->export('xls');
    }

    /* Buy */
    public function itemBuy(){
        $data['title'] = 'Laporan Barang Yang Harus Dibeli';
        return view($this->folder . '.itemBuy',$data);
    }

    public function getDataTableItemBuy(Request $request){
        return (new ReportsItemBuyDataTables($this->item, $request))->make();
    }

    public function excelBuy(Request $request){
        $collectData = collect();

        $listProduct=$this->item->select('*')->get();
     
        foreach ($listProduct as $keyP => $valueP) {

            $check = $this->itemStock->where('id_item',$valueP->id)->sum('stok');
            if ($check) {
                if ($check<1) {
                    $collectData->push([
                        'item' => $valueP->name,
                        'stock' => 0
                    ]);
                }
            }else{
                $collectData->push([
                    'item' => $valueP->name,
                    'stock' => 0
                ]);
            }
        }

        $title = "Laporan Stok Barang Yang Harus Dibeli";


        $rowData['data']=$collectData;
        $rowData['by']=\Carbon\Carbon::now()->format('d F Y');

        ob_end_clean();
        return \Excel::create('Import Products Buy ', function($excel) use ($rowData) {

            $excel->sheet('Report Import Products Buy', function($sheet) use ($rowData) {

                $sheet->loadView($this->folder.'.excelBuy',$rowData);

            });

        })->export('xls');
    }

    public function pdf(){
		$pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML('<h1>Test</h1>');
		return $pdf->stream();
    }
}
