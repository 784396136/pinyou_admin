<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // 文章列表
    public function list()
    {
        return view('article.list');
    }

    // 文章列表
    public function sort()
    {
        return view('article.sort');
    }
}
