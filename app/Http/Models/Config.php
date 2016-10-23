<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = 'config';
    protected  $primaryKey = 'conf_id';
    public $timestamps = false;
    protected $guarded = [];//与fillable相反
}
