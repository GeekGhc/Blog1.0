<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Home\CommonController;
use App\Http\Models\Article;
use App\Http\Models\Category;
use App\Http\Models\Links;
use App\Http\Models\Navs;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends CommonController
{
    public function index()
    {
        //点击量最高的文章(Recommend)
        $pics = Article::orderBy('art_view','desc')->take(6)->get();


        //图文列表(分页)
        $data = Article::orderBy('art_time','desc')->paginate(5);

        //友情链接
        $links = Links::orderBy('link_order','asc')->get();

        return view('home.index',compact('hot','pics','data','new','links'));
    }

    public function cate($cate_id)
    {
        $field = Category::find($cate_id);
        //图文列表(分页)
        $data = Article::where('cate_id',$cate_id)->orderBy('art_time','desc')->paginate(4);

        //查看次数的自增
       Category::where('cate_id',$cate_id)->increment('cate_view');

        //当前分类的子分类
        $submenu  =  Category::where('cate_pid',$cate_id)->get();

        return view('home.list',compact('field','data','submenu'));
    }

    public function article($art_id)
    {
        $field = Article::Join('category','article.cate_id','=','category.cate_id')->where('art_id',$art_id)->first();

        //查看次数的自增
        Article::where('art_id',$art_id)->increment('art_view');

        $article['pre'] = Article::where('art_id','<',$art_id)->orderBy('art_id','desc')->first();
        $article['next'] = Article::where('art_id','>',$art_id)->orderBy('art_id','asc')->first();

        $data = Article::where('cate_id',$field->cate_id)->orderBy('art_id','desc')->take(6)->get();

        return view('home.new',compact('field','article','data'));
    }
}
