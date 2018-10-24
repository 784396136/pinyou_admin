<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    // 店铺列表
    public function list()
    {
        return view('shop.list');
    }

    // 店铺审核
    public function audit()
    {
        return view('shop.audit');
    }

    // 审核详情页
    public function detailed()
    {
        return view('shop.detailed');
    }
}
