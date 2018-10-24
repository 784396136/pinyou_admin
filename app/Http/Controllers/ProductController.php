<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    //产品类
    public function list()
    {
        return view('product.list');
    }

    // 添加产品
    public function picture_add()
    {
        return view('product.picture_add');
    }

    // 品牌管理
    public function manage()
    {
        return view('product.manage');
    }

    // 品牌添加
    public function manage_add()
    {
        return view('product.add_brand');
    }

    // 分类管理
    public function category()
    {
        return view('product.category');
    }

    public function category_add()
    {
        return view('product.category_add');
    }
}
