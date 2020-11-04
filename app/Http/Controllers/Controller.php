<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Modules;
use App\Models\Roles;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function can($function)
    {
        $info = (new Modules)->makeInfo($this->url);
        $roleName = (new Roles)->name(\Auth::user()->id_role);
        
        if (empty($roleName)) {
            abort(403);
        }

        if ( ($roleName != 'superadmin') ) {
            $getAccess = $info ? 
                            (new Modules)->validAccess($info['id'],\Auth::user()->id_role) : "";
            if (isset($getAccess[$function])) {
                if ($getAccess == "" || $getAccess[$function] == 0)
                    abort(403);
            }else{
              abort(403);
            }
        }
    }
}
