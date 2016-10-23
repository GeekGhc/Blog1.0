<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Navs;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class NavsController extends Controller
{
    /**
     * 全部友情导航列表
     */
    public function index()
    {
        $data = Navs::orderBy('nav_order','asc')->get();
//        dd($data);
        return view('admin.navs.index',compact('data'));
    }

    /**
     * 添加友情导航
     */
    public function create()
    {
        return view('admin.navs.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = Input::except('_token');

        $rules = [
            'nav_name'=>'required',
            'nav_url'=>'required'
        ];
        $message = [
            'nav_name.required'=>'导航名称不能为空',
            'nav_url.required'=>'导航url不能为空',
        ];
        $validator = Validator::make($input,$rules,$message);

        //判断validator  如果错误返回错误信息
        if($validator->passes()){
            $res = Navs::create($input);
            if($res){
                return redirect('admin/navs');
            }else{
                return Redirect::back()->with('errors','导航添加失败,请稍后重试');
            }
        }else{
            return Redirect::back()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * 编辑导航
     */
    public function edit($nav_id)
    {
        $field = Navs::find($nav_id);
        return view('admin.navs.edit',compact('field'));
    }

    /**
     * 更新导航
     */
    public function update(Request $request, $nav_id)
    {
        $input = Input::except('_token','_method');
        $res = Navs::where('nav_id',$nav_id)->update($input);
        if($res){
            return redirect('admin/navs');
        }else{
            return Redirect::back()->with('errors','导航信息更新失败,请稍后重试');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($nav_id)
    {
        $res = Navs::where('nav_id',$nav_id)->delete();
        if($res){
            $data = [
                'status' => 1,
                'msg'    =>'导航删除成功'
            ];
        }else{
            $data = [
                'status' => 0,
                'msg'    =>'导航删除失败'
            ];
        }
        return $data;
    }

    public function changeOrder(){
        $input = Input::all();
        $nav = Navs::find($input['nav_id']);
        $nav->nav_order = $input['nav_order'];
        $res = $nav->update();
        if($res){
            $data = [
                'status' => 1,
                'msg'    =>'友情导航排序更新成功'
            ];
        }else{
            $data = [
                'status' => 0,
                'msg'    =>'友情导航排序更新失败'
            ];
        }
        return $data;
    }
}
