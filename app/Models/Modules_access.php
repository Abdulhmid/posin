<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modules_access extends Model
{
    protected $table = 'modules_access';
    protected $guarded = ['id'];
    protected $primaryKey = "id"; 
}
