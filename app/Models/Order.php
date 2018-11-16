<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\G_cart;
use App\Models\O_goods;
use DB;

class Order extends Model
{
    // 指定表
    protected $table = 'order';
    // 设置白名单
    protected $fillable = ['order_number','name','moble','address','total_price'];

    // 生成唯一订单号
    public function get_orderID()
    {
        $order_id_main = date('YmdHis') . rand(10000000,99999999);
        $order_id_len = strlen($order_id_main);
        $order_id_sum = 0;
        for($i=0; $i<$order_id_len; $i++){
            $order_id_sum += (int)(substr($order_id_main,$i,1));
        }
        $osn = $order_id_main . str_pad((100 - $order_id_sum % 100) % 100,2,'0',STR_PAD_LEFT);
        return $osn;
    }

    // 保存订单
    public function add($data)
    {
        $order = new self;
        $order->fill($data);
        $order->save();
        $order_id = DB::getPdo()->lastInsertId();
        // 获取所购买的商品SKU ID
        $skuId = DB::table('goods_cart as gc')
                ->select('gs.id')
                ->leftJoin('goods_sku as gs','gc.attr','gs.attr')
                ->whereIn('gc.id',$data['goods_id'])
                ->get()
                ->toArray();
        foreach($skuId as $k=>$v)
        {
            $order_goods = new O_goods;
            $info = [];
            $info['order_id'] = $order_id;
            $info['sku_id'] = $v->id;
            $info['stock'] = $data['goods_stock'][$k];
            $order_goods->fill($info);
            $order_goods->save();
        }
    }
}
