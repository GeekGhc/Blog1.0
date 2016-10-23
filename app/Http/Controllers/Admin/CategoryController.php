<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CategoryController extends CommonController
{
    /**
     * 全部分类列表
     */
    protected $cate;

    public function __construct(Category $cate)
    {
        $this->cate = $cate;
    }

    public function index()
    {
        $data = $this->cate->tree();
//        $data = (new Category)->tree();
        return view('admin.category.index')->with('data',$data);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = Category::where('cate_pid',0)->get();
        return view('admin/category/add',compact('data'));
    }


    public function store(Request $request)
    {
        $input = Input::except('_token');
//        dd($input);

        $rules = [
            'cate_name'=>'required',
        ];
        $message = [
            'cate_name.required'=>'分类名称不能为空',
        ];
        $validator = Validator::make($input,$rules,$message);

        //判断validator  如果错误返回错误信息
        if($validator->passes()){
            $res = Category::create($input);
            if($res){
                return redirect('admin/category');
            }else{
                return Redirect::back()->with('errors','数据填充失败,请稍后重试');
            }
        }else{
            return Redirect::back()->withErrors($validator);
        }
    }

    /**
     * 显示单个分类的信息
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function edit($cate_id)
    {
        $field = Category::find($cate_id);
        $data = Category::where('cate_pid',0)->get();
        return view('admin.category.edit',compact('field','data'));
    }



    public function update(Request $request, $cate_id)
    {
        $input = Input::except('_token','_method');
        $res = Category::where('cate_id',$cate_id)->update($input);
        if($res){
            return redirect('admin/category');
        }else{
            return Redirect::back()->with('errors','分类信息更新失败,请稍后重试');
        }
    }

    /**
     * 删除单个分类
     */
    public function destroy($cate_id)
    {
        $res = Category::where('cate_id',$cate_id)->delete();
        Category::where('cate_pid',$cate_id)->update(['cate_pid'=>0]);
        if($res){
            $data = [
                'status' => 1,
                'msg'    =>'分类删除成功'
            ];
        }else{
            $data = [
                'status' => 0,
                'msg'    =>'分类删除失败'
            ];
        }
        return $data;

    }

    public function changeOrder(){
        $input = Input::all();
        $cate = Category::find($input['cate_id']);
        $cate->cate_order = $input['cate_order'];
        $res = $cate->update();
        if($res){
            $data = [
                'status' => 1,
                'msg'    =>'分类排序更新成功'
            ];
        }else{
            $data = [
                'status' => 0,
                'msg'    =>'分类排序更新失败'
            ];
        }
        return $data;
    }
}
