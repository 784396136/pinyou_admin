<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Goods;
use App\Models\G_sku;

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
}
