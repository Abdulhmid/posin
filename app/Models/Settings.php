<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'config';
    protected $guarded = ['id'];
    protected $primaryKey = "id";   
}
