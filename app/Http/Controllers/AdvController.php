<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdvController extends Controller
{
    // 广告管理
    public function adv()
    {
        return view('ad.advertising');
    }

    // 分类管理
    public function sort_ads()
    {
        return view('ad.sort_ads');
    }
}
