<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Services\ProductsService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductsRequest;
use App\DataTables\ProductsDataTables;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Forms\ProductsForm;
use App\Models as Md;

class ProductsController extends Controller
{
    protected $title = "Products";
    protected $url = "products";
    protected $folder = "admin.products";
    protected $form;

    public function __construct(
        ProductsService $service,
        Md\Products_price $service_price
    )
    {
        $this->service       = $service;
        $this->service_price = $service_price;
        $this->form     = ProductsForm::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductsDataTables $dataTable)
    {        
        $data['title'] = $this->title;

        return $dataTable->render($this->folder . '.index', $data);
    }

    /**
     * Show the form for inviting a customer.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create($this->form, [
            'method' => 'POST',
            'route' => $this->url . '.store'
        ]);

        return view($this->folder . '.form', [
            'title' => $this->title,
            'form' => $form,
            'breadcrumb' => 'new-' . $this->url
        ]);
    }

    /**
     * Show the form for inviting a customer.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ProductsRequest $request)
    {
        $result = $this->service
                    ->create(
                        $request->except([
                            '_token', '_method',
                            'save_continue','purchase_price',
                            'selling_price','procentage'
                        ]),
                        $request->only([
                           'purchase_price','selling_price'
                        ])
                    );

        $rest = $result->id;
        $save_continue = $request->get('save_continue');
        $redirect = empty($save_continue) ?$this->url : 
                                           $this->url.'/'.$rest.'/edit';

        if ($result) {
            return redirect()->to($redirect)->with('message', 'Successfully created');
        }

        return back()->with('error', 'Failed to invite');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(FormBuilder $formBuilder,$id)
    {
        $model = $this->service->find($id);
        $modelPrice = $this->service_price->where('id_item',$id)->first();
        $findProcentage = ($modelPrice->selling_price)-($modelPrice->purchase_price);
        $procentage = ($findProcentage/$modelPrice->purchase_price)*100;

        $form = $formBuilder->create($this->form, [
            'method' => 'PUT',
            'url' => route($this->url . '.update', $id),
            'model' => $model
        ])->modify('purchase_price','number',[
            'value' => (int)$modelPrice->purchase_price,
        ])->modify('procentage','number',[
            'value' => (int)$procentage,
        ])->modify('selling_price','number',[
            'value' => (int)$modelPrice->selling_price,
        ]);

        return view($this->folder . '.form', [
            'title' => $this->title,
            'form' => $form,
            'breadcrumb' => 'new-' . $this->url
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductsRequest $request, $id)
    {
        $result = $this->service
                    ->update(
                        $id, 
                        $request->except([
                            '_token', '_method',
                            'save_continue','purchase_price',
                            'selling_price','procentage'
                        ]),
                        $request->only([
                           'purchase_price','selling_price'
                        ])
                    );

        $result = $id;
        $save_continue = $request->get('save_continue');
        $redirect = empty($save_continue) ?$this->url : 
                                           $this->url.'/'.$result.'/edit';

        if ($result) {
            return redirect()->to($redirect)->with('message', 'Successfully updated');
        }

        return back()->with('error', 'Failed to update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->service->destroy($id);

        if ($result) {
            return redirect()->to($this->url)->with('message', 'Successfully deleted');
        }

        return back()->with('error', 'Failed to delete');
    }
}
