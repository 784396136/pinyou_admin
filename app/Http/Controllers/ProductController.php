<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;

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
        $brand = new Brand;
        $data = $brand->getAll();
        return view('product.manage',[
            'data'=>$data
        ]);
    }

    // 品牌添加
    public function manage_add()
    {
        return view('product.add_brand');
    }

    public function domanage_add(Request $req)
    {
        $model = new Brand;
        $res = $model->add($req->all());
        if($res)
        {
            return redirect()->route('ProductManage');
        }
        else
        {
            return back()->with('error','该品牌已存在')->withInput();
        }
    }

    // 分类管理
    public function category()
    {
        $category = new Category;
        $cat = $category->get1A2();
        $all = $category->getAll();
        return view('product.category',[
            'category'=>$cat,
            'all'=>$all,
        ]);
    }

    public function category_add(Request $req)
    {
        $data = $req->all();
        $category = new Category;
        $category->add($data);
    }
}
