<?php

namespace App\Http\Controllers\Home;

use App\Http\Models\Article;
use App\Http\Models\Navs;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
    public function __construct()
    {
        $navs = Navs::all();

        //点击量最高的文章
        $hot = Article::orderBy('art_view','desc')->take(5)->get();

        //八篇最新文章
        $new = Article::orderBy('art_time','desc')->take(8)->get();

        View::share('navs',$navs);
        View::share('hot',$hot);
        View::share('new',$new);
    }
}
