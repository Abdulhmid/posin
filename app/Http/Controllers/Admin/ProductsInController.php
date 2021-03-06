<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Services\InService;
use App\Http\Controllers\Controller;
use App\Http\Requests\InRequest;
use Kris\LaravelFormBuilder\FormBuilder;
use App\DataTables\InProductsDataTables;
use App\Forms\InForm;

class ProductsInController extends Controller
{
    protected $title = "Barang Masuk";
    protected $url = "in";
    protected $folder = "admin.in";
    protected $form;

    public function __construct(
    	InService $service
    )
    {
        $this->service  = $service;
        $this->form = InForm::class;
    }

    public function index(FormBuilder $formBuilder)
    {        
        $form = $formBuilder->create($this->form, [
            'method' => 'POST',
            'route' => $this->url . '.store'
        ]);

        return view($this->folder . '.index', [
            'title' => $this->title,
            'form' => $form,
            'breadcrumb' => 'new-' . $this->url
        ]);
    }

    public function store(InRequest $request)
    {
        $result = $this->service
                    ->create($request->except(['_token', '_method','save_continue']));

        $rest = $result->id;
        $save_continue = $request->get('save_continue');
        $redirect = empty($save_continue) ?$this->url : 
                                           $this->url.'/'.$rest.'/edit';

        if ($result) {
            return redirect()->to($redirect)->with('message', 'Successfully created');
        }

        return back()->with('error', 'Failed to invite');
    }

    public function history(InProductsDataTables $dataTable)
    {        
        $data['title'] = $this->title;

        return $dataTable->render($this->folder . '.history', $data);
    }
}
