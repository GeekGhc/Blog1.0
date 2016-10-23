<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Links extends Model
{
    protected $table = 'links';
    protected  $primaryKey = 'link_id';
    public $timestamps = false;
    protected $guarded = [];//与fillable相反
}
