<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'article';
    protected  $primaryKey = 'art_id';
    public $timestamps = false;
    protected $guarded = [];//与fillable相反
}
