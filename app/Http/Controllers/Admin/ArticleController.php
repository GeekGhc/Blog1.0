<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Article;
use App\Http\Models\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController
{
    /**
     * 全部的文章列表
     */
    public function index()
    {
        $data = Article::orderBy('art_id','desc')->paginate(5);
//        dd($data->links());
        return view('admin.article.index',compact('data'));
    }

    /**
     * 添加文章
     */
    public function create()
    {
        $data = (new Category)->tree();
        return view('admin.article.add',compact('data'));
    }

    /**
     * 添加文章提交
     */
    public function store(Request $request)
    {
        $input = Input::except('_token');
        $input['art_time'] = time();

        $rules = [
            'art_title'=>'required',
            'art_content'=>'required',
        ];
        $message = [
            'art_title.required'=>'文章名称不能为空',
            'art_content.required'=>'文章内容不能为空',
        ];
        $validator = Validator::make($input,$rules,$message);

        //判断validator  如果错误返回错误信息
        if($validator->passes()){
            $res = Article::create($input);
            if($res){
                return redirect('admin/article');
            }else{
                return Redirect::back()->with('errors','数据填充失败,请稍后重试');
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
     * 编辑文章
     */
    public function edit($art_id)
    {
        $data = (new Category)->tree();
        $field = Article::find($art_id);
        return view('admin.article.edit',compact('data','field'));
    }

    /**
     * 更新文章内容
     */
    public function update(Request $request, $art_id)
    {
        $input = Input::except('_token','_method');
        $res = Article::where('art_id',$art_id)->update($input);
        if($res){
            return redirect('admin/article');
        }else{
            return Redirect::back()->with('errors','文章信息更新失败,请稍后重试');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($art_id)
    {
        $res = Article::where('art_id',$art_id)->delete();
        if($res){
            $data = [
                'status' => 1,
                'msg'    =>'文章删除成功'
            ];
        }else{
            $data = [
                'status' => 0,
                'msg'    =>'文章删除失败'
            ];
        }
        return $data;
    }
}
