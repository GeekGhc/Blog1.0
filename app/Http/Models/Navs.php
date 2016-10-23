<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Navs extends Model
{
    protected $table = 'navs';
    protected  $primaryKey = 'nav_id';
    public $timestamps = false;
    protected $guarded = [];//与fillable相反
}
