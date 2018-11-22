<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Goods;
use App\Models\G_cart;


class IndexController extends Controller
{
    // 主页
    public function index()
    {
        $category = new Category;
        $cate = $category->getChild();
        $cart = new G_cart;
        $cart_info = $cart->getAll();
        if($cart_info)
        {
            $sum_price = 0;
            foreach($cart_info['data'] as $v)
            {
                $sum_price += $v->price * $v->stock;
            }
        }
        return view('index.index',[
            'category'=>$cate,
            'cart_info'=>$cart_info,
            'sum_price'=>$sum_price
        ]);
    }

    // 搜索页
    public function search($cate_id)
    {
        // 获取分类
        $brand = new Brand;
        $brands = $brand->getById($cate_id);
        // 获取品牌
        $category = new Category;
        $cate = $category->getParent($cate_id);
        // 获取商品
        $shop = new Goods;
        $shops = $shop->getShops($cate_id);
        return view('index.search',[
            'cate'=>$cate,
            'brands'=>$brands,
            'shops'=>$shops,
        ]);
    }
}
