<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Goods;
use App\Models\G_sku;
use App\Models\G_cart;

class GoodsController extends Controller
{
    // 详情页面
    public function info($sku_id)
    {
        $goods = new Goods;
        $data = $goods->getInfo($sku_id);
        return view("index.item",[
            'data'=>$data
        ]);
    }

    // ajax获取数据
    public function ajax_getInfo(Request $req)
    {
        $data = $req->all();
        $goods_id = $data['goods_id'];
        $attr = $data['attr_str'];
        $model = new G_sku;
        $id = $model->getInfo($goods_id,$attr);
        $old_url = url()->previous();
        $url = substr($old_url,0,strrpos($old_url,'/')).'/'.$id['id'];
        echo json_encode($url);
    }

    // 购物车
    public function cart_info()
    {
        $g_cart = new G_cart;
        $data = $g_cart->getAll();
        $sum_price = 0;
        foreach($data['data'] as $v)
        {
            $sum_price += $v->price * $v->stock;
        }
        return view('index.cart',[
            'sum_price'=>$sum_price,
            'data'=>$data
        ]);
    }

    // 结算
    public function makeOrder(Request $req)
    {
        $data = $req->all();
        $g_cart = new G_cart;
        $res = $g_cart->OrderGoods($data);
        $sum_price = 0;
        foreach($res as $v)
        {
            $sum_price += $v['stock'] * $v['price'];
        }
        return view('index.getOrderInfo',[
            'data'=>$res,
            'sum_price'=>$sum_price,
        ]);
    }


    // 添加购物车
    public function ajax_addCart(Request $req)
    {
        $data = $req->all();
        $data['user_id'] = session('user_id');
        $g_cart = new G_cart;
        $id = $g_cart->add($data);
        if($id)
        {
            echo json_encode($id);
        }
        else
        {
            echo json_encode(0);
        }
    }

    // 添加成功
    public function addSuccess($id)
    {
        $g_cart = new G_cart;
        $data = $g_cart->success_info($id);
        return view('index.success_cart',[
            'data'=>$data
        ]);
    }
}