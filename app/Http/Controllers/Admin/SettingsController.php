<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Settings;

class SettingsController extends Controller
{
    protected $title = "Pengaturan";
    protected $url = "settings";
    protected $folder = "admin.settings";
    protected $form;

    public function __construct(Settings $model)
    {
        $this->model = $model;
    }

    public function index(){
		$data['title'] = $this->title;
        return view($this->folder . '.index',$data);
    }

    public function store(Request $request){

        /* Config Background */
        $this->model
            ->where('key','background')
            ->where('id_client',\Auth::user()->id_client)
            ->delete();

        $this->model->create([
                'key'       => 'background',
                'id_client' => \Auth::user()->id_client,
                'value' => $request['background']
            ]);

        return redirect('/settings')->with('message',
            'Pengaturan Berhasil diubah!')->withInput($request->all());
    }
}
