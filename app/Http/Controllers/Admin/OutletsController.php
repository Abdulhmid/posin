<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Services\OutletsService;
use App\Http\Controllers\Controller;
use App\Http\Requests\OutletsRequest;
use App\DataTables\OutletsDataTables;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Forms\OutletsForm;

class OutletsController extends Controller
{
    protected $title = "Outlets";
    protected $url = "outlets";
    protected $folder = "admin.outlets";
    protected $form;

    public function __construct(OutletsService $service)
    {
        $this->service = $service;
        $this->form     = OutletsForm::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OutletsDataTables $dataTable)
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
    public function store(OutletsRequest $request)
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(FormBuilder $formBuilder,$id)
    {
        $model = $this->service->find($id);

        $form = $formBuilder->create($this->form, [
            'method' => 'PUT',
            'url' => route($this->url . '.update', $id),
            'model' => $model
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
    public function update(OutletsRequest $request, $id)
    {
        $result = $this->service
                    ->update($id, $request->except(['_token', '_method','save_continue']));

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
