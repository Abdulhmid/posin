<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Services\ModulesService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ModulesRequest;
use App\DataTables\ModulesDataTables;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Forms\ModulesForm;
use App\Models as Md;

class ModulesController extends Controller
{
    protected $title = "Modules";
    protected $url = "modules";
    protected $folder = "admin.modules";
    protected $form;

    public function __construct(
        ModulesService $service,
        Md\Modules $model,
        Md\Roles_client $roles,
        Md\Modules_access $modules_access
    )
    {
        $this->service  = $service;
        $this->model    = $model;
        $this->roles    = $roles;
        $this->modules_access = $modules_access;
        $this->form     = ModulesForm::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ModulesDataTables $dataTable)
    {        
        $this->can('index');
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
    public function store(ModulesRequest $request)
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
    public function update(ModulesRequest $request, $id)
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

    public function access(){
        $data['title'] = $this->title;
        $data['roles'] = $this
            ->roles
            ->with(['role'])
            ->where('id_client',\Auth::user()->id_client)
            ->get();

        $data['modules'] = $this->service->all();

        return view($this->folder . '.acl', $data);
    }

    public function accessPost(Request $request){
        $roleLoop = $this->roles
                        ->where('id_client',\Auth::user()->id_client)
                        ->pluck('id')->toArray();
        try {
            \DB::beginTransaction();
            foreach ($roleLoop as $valueRole) {
                $modules = $this->model
                            ->where('id_client',\Auth::user()->id_client)
                            ->get()->toArray();
                foreach ($modules as $value) {
                    $array = [];
                    /* Check Is Selected Function  */
                    foreach (\AclHelper::takeFunction($value['module_id'], "origin") as $function) {
                        $field = 'function' . $valueRole . $value['module_id'] . $function;
                        $getField = $request->get($field);

                        $array[$function] = (isset($getField) && "on" == $getField ? "1" : "0");
                    }
                    /* Encode From Array */
                    $dummy = json_encode($array);
                    $accessData = preg_replace('/\s/', '', $dummy);

                    $checkExist = $this->modules_access->where([
                        'role_id' => $valueRole,
                        'id_client' => \Auth::user()->id_client,
                        'module_id' => $value['module_id'],
                    ])->first();

                    if (!is_null($checkExist)) {
                        $checkExist->update(['access_data' => $accessData]);
                    } else {
                        $this->modules_access->create([
                            'id_client' => \Auth::user()->id_client,
                            'role_id' => $valueRole,
                            'module_id' => $value['module_id'],
                            'access_data' => $accessData,
                        ]);
                    }
                }
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::info($e);

            return redirect($this->url.'/access')->with('error', 
            				'Terjadi Kesalahan, Coba lagi.');
        }

        return redirect($this->url.'/access')->with('message', 'Konfigurasi Berhasil!');
    }
}
