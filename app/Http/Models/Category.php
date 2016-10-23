<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected  $primaryKey = 'cate_id';
    public $timestamps = false;
    protected $guarded = [];//与fillable相反

    public function tree()
    {
        $categorys = $this->orderBy('cate_order','asc')->get();
        return $data = $this->getTree($categorys,'cate_name','cate_id','cate_pid',0);
    }

    public function getTree($data,$filed_name,$filed_id='id',$filed_pid='pid',$pid=0)
    {
        $arr = array();
        foreach($data as $k=>$v){
            if($v->$filed_pid==$pid){
                $data[$k]['_'.$filed_name] = $data[$k][$filed_name];
                $arr[] = $data[$k];
                foreach($data as $m=>$n){
                    if($n->$filed_pid==$v->$filed_id){
                        $data[$m]['_'.$filed_name] = '╘--  '.$data[$m][$filed_name];
                        $arr[] = $data[$m];
                    }
                }
            }
        }
//        dd($arr);
        return $arr;
    }
}
