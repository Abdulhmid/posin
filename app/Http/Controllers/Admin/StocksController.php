<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\StocksDataTables;
use App\DataTables\StocksBrokenDataTables;

class StocksController extends Controller
{
    protected $title = "Stok Gudang";
    protected $url = "stocks";
    protected $folder = "admin.stocks";
    protected $form;

    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(StocksDataTables $dataTable)
    {        
        $data['title'] = $this->title;

        return $dataTable->render($this->folder . '.index', $data);
    }

    /*
	 * Stokc Broken
    */
    public function broken(StocksBrokenDataTables $dataTable)
    {        
        $data['title'] = $this->title." Rusak";

        return $dataTable->render($this->folder . '.index', $data);
    }
}
