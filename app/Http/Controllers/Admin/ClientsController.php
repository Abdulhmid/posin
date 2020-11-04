<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Services\ClientsService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientsRequest;
use App\DataTables\ClientsDataTables;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Forms\ClientsForm;
use App\User;
use App\Models as Md;

class ClientsController extends Controller
{
    protected $title = "Clients";
    protected $url = "clients";
    protected $folder = "admin.clients";
    protected $form;

    public function __construct(
        ClientsService $service,
        Md\Roles $roles,
        Md\Outlets $outlets,
        Md\Roles_client $roles_client,
        User $user
    )
    {
        $this->service  = $service;
        $this->roles    = $roles;
        $this->outlets  = $outlets;
        $this->roles_client = $roles_client;
        $this->user     = $user;
        $this->form     = ClientsForm::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ClientsDataTables $dataTable)
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
    public function store(ClientsRequest $request)
    {
        $result = $this->service
                    ->create($request->except(['_token', '_method','save_continue']));

        $rest = $result->id;
        $save_continue = $request->get('save_continue');
        $redirect = empty($save_continue) ?$this->url : 
                                           $this->url.'/'.$rest.'/edit';

        $this->createRoles($rest);
        $this->createUser($rest,$result);

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
    public function update(ClientsRequest $request, $id)
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

    /* Create Default Role Clients */
    private function createRoles($client){
        $rolesDefault = $this->roles->whereIn('label',['admin','cashier'])->get();
        foreach ($rolesDefault as $key => $value) {
            $this->roles_client->create([
                'id_role' => $value->id,
                'id_client' => $client
            ]);
        }
    }

    /* Create Default Users */
    private function createUser($client,$row){
        $idRole = $this->roles_client->where('id_client',$client)
                    ->whereHas('role',function($q){
                        $q->where('label','admin');
                    })->first()->id;

        $rowOutlet = $this->outlets->create([
            'name' => $row->name,
            'email' => $row->email,
            'handphone' => '-',
            'telp' => '-',
            'city_id' => $row->city_id,
            'id_client' => $client,
            'address' => '-',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        if ($idRole) {
            $this->user->create([
                    'username' => strtolower(preg_replace('/\s+/', '_', $row->name)),
                    'name' => $row->name,
                    'email' => $row->email,
                    'password' => bcrypt($row->email),
                    'id_role' => $idRole,
                    'id_client' => $client,
                    'id_outlet' => $rowOutlet->id,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
            ]);
        }
    }

}
