<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Products;
use App\Models\Products_stock;
use App\Models\Products_stocks_broken;
use App\Models\Transactions;
use App\Models\Transactions_detail;
use App\Models\Transactions_return;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        Users $users,
        Products $products,
        Products_stock $products_stock,
        Products_stocks_broken $products_stock_broke,
        Transactions $transactions,
        Transactions_detail $transactions_detail,
        Transactions_return $transactions_return
    )
    {
        $this->middleware('auth');
        $this->users = $users;
        $this->products = $products;
        $this->products_stock   = $products_stock;
        $this->products_stock_broke   = $products_stock_broke;
        $this->transactions     = $transactions;
        $this->transactions_detail = $transactions_detail;
        $this->transactions_return = $transactions_return;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "coming";
    }

    public function pos()
    {
        return view('admin.home_new');
    }

    public function return()
    {
        return view('admin.return');
    }

    public function getItem(Request $request){
        # return $this->products->search($q)->with('item_price')->get();
        $q = $request->get('q');
        $row = $this->products
                    ->where(\DB::raw('lower(name)'),'like','%'.strtolower($q).'%')
                    ->with(['pricelist','stock'])
                    ->get();
        return response()->json($row);
    }

    public function me()
    {
        $data['title']  = "Pengaturan Akun";
        $data['row']    = $this->users->find(\Auth::user()->id);
        return view('admin.me',$data);
    }

    public function postStoreProfile($id, Request $request){

        $input = $request->all();
        $rules = array(
            'email' =>'required',
            'name'  =>'required',
            'photo' =>'',
            'password'  => 'min:6|confirmed',
            'password_confirmation' => 'min:6'
        );      

        if( $request->hasFile('photo'))
            $photo  = (new \ImageUpload($input))->upload();

        $validator = \Validator::make(\Request::all(), $rules);
        if ($validator->passes()) { 
            $data = [
                'email' => $input['email'],
                'name'  => $input['name']
            ];

            if(!empty($input['password'])) {
                $data = [
                    'password' => bcrypt($input['password'])
                ];  
            }

            if($request->hasFile('photo'))
                $data = [
                    'photo' => isset($photo) ? $photo : ""
                ];  $this->users->find($id)->update($data);

            return \Redirect::back()->with('message',
                'Ubah Data Sukses!')->withInput($request->all());
        }else{
            return redirect('/me')->withErrors($validator);
        }

    }

    public function posAction(Request $request){
        $countRow = count($request['item']);
        
        $rowTrans = $this->transactions->create([
                'id_trans' => \GenerateHelper::generateCode(),
                'id_user'  => \Auth::user()->id,
                'additional_info'  => $request['additional_info'],
                'date_transaction' => \Carbon\Carbon::now()
            ]);

        for ($i=0; $i < $countRow; $i++) { 
            $this->transactions_detail->create([
                    'id_trans' => $rowTrans->id_trans,
                    'id_item' => $request['item'][$i],
                    'qty' => $request['qty'][$i],
                    'amount' => $request['amount'][$i],
                    'discount' => $request['discount'][$i]
                ]);

            $this->downStock($request['item'][$i],$request['qty'][$i]);
        }

        return $rowTrans;
    }

    public function posReturn(Request $request){
        $countRow = count($request['idrow']);
        
        for ($i=0; $i < $countRow; $i++) { 
            $idTr = $request['idtrans'][$i];
            if ($request['qty'][$i] <> "0") {
                $oldData=$this->transactions_detail->find($request['idrow'][$i]);

                $this->transactions_return->create([
                    'id_item'=>$request['item'][$i],
                    'qty'=>$request['qty'][$i],
                    'reason'=>$request['additional_info'],
                    'amount'=>0,
                    'discount'=>0
                ]);

                $checkBrokeItem=$this->products_stock_broke->where('id_item',$request['item'][$i]);
                if ($checkBrokeItem->count()>0) {
                    $this->products_stock_broke->where('id_item',$request['item'][$i])
                    ->update([
                        'stok'=>$checkBrokeItem->first()->stok+$request['qty'][$i]
                    ]);
                }else{
                    $this->products_stock_broke->create([
                        'id_item'=>$request['item'][$i],
                        'stok'=>$request['qty'][$i],
                    ]);
                }

                $this->downStock($request['item'][$i],$request['qty'][$i]);
            }

        }

        return $idTr;
    }

    public function printPdf($idTrans=""){
        /* Add folder fonts inner storage */
        $data['row'] = $this->transactions->with(['detail'])->where('id_trans',$idTrans)->get();
        // return $data['row'];
        
        $pdf = \PDF::loadView('pdf.struck', $data);
        return $pdf->stream('invoice.pdf');
    }

    public function findReturn($idTrans=""){
        $row['data'] = $this->transactions_detail->with(['item'])->where('id_trans',$idTrans)->get();
        $check= $this->transactions_detail->with(['item'])->where('id_trans',$idTrans)->first();
        if ($check) {

            $endF = \Carbon\Carbon::parse($check->created_at)->format('Y-m-d');
            $end = \Carbon\Carbon::parse($endF);
            $now = \Carbon\Carbon::now();
            $length = $end->diffInDays($now);

            if ($length>2) {
                /* expired */
                $row['action'] = 0;
            }else{
                /* ok */
                $row['action'] = 1;
            }
        }else{
            /* No data */
            $row['action'] = 2;
        }
        return $row;
    }

    /* Update Stock */
    public function downStock($idItem, $total){
        $find = $this->products_stock->where('id_item',$idItem);
        $find->update([
            'stok' => ($find->first()->stok) - $total
        ]);
        return $find;
    }
}
