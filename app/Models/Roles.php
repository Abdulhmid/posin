<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model {

    protected $table = 'roles';
    protected $guarded = ['id'];
    protected $primaryKey = "id";

    public function name($id = "")
    {
        $row = $this->where('id', $id)->first();
        if ($row) {
        	$return = $row->label;
        }else{
        	$return = "";
        }
        return $return;
    }   
}

