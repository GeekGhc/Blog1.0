<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Links;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class LinksController extends Controller
{
    /**
     * 全部友情链接列表
     */
    public function index()
    {
        $data = Links::orderBy('link_order','asc')->get();
//        dd($data);
        return view('admin.links.index',compact('data'));
    }

    /**
     * 添加友情链接
     */
    public function create()
    {
        return view('admin.links.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = Input::except('_token');

        $rules = [
            'link_name'=>'required',
            'link_url'=>'required'
        ];
        $message = [
            'link_name.required'=>'链接名称不能为空',
            'link_url.required'=>'链接url不能为空',
        ];
        $validator = Validator::make($input,$rules,$message);

        //判断validator  如果错误返回错误信息
        if($validator->passes()){
            $res = Links::create($input);
            if($res){
                return redirect('admin/links');
            }else{
                return Redirect::back()->with('errors','链接添加失败,请稍后重试');
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
     * 编辑链接
     */
    public function edit($link_id)
    {
        $field = Links::find($link_id);
        return view('admin.links.edit',compact('field'));
    }

    /**
     * 更新链接
     */
    public function update(Request $request, $link_id)
    {
        $input = Input::except('_token','_method');
        $res = Links::where('link_id',$link_id)->update($input);
        if($res){
            return redirect('admin/links');
        }else{
            return Redirect::back()->with('errors','链接信息更新失败,请稍后重试');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($link_id)
    {
        $res = Links::where('link_id',$link_id)->delete();
        if($res){
            $data = [
                'status' => 1,
                'msg'    =>'链接删除成功'
            ];
        }else{
            $data = [
                'status' => 0,
                'msg'    =>'链接删除失败'
            ];
        }
        return $data;
    }

    public function changeOrder(){
        $input = Input::all();
        $link = Links::find($input['link_id']);
        $link->link_order = $input['link_order'];
        $res = $link->update();
        if($res){
            $data = [
                'status' => 1,
                'msg'    =>'友情链接排序更新成功'
            ];
        }else{
            $data = [
                'status' => 0,
                'msg'    =>'友情链接排序更新失败'
            ];
        }
        return $data;
    }
}
