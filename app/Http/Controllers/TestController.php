<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seller;
use App\Models\Order;
use App\Models\O_goods;
use App\Models\G_cart;
use DB;
use App\Models\G_sku;

class TestController extends Controller
{
    public function index()
    {
        // 开启事务
        DB::beginTransaction();
                        
        // 将订单状态修改为已提交
        $res = Order::where('order_number','201811181821328552315725')->update(['pay_status'=>'1']);
        $order_id = Order::select('id')->where('order_number','201811181821328552315725')->first();
        $res1 =  O_goods::where('order_id',$order_id->id)->update(['pay_status'=>'1']);
        // 获取付款商品的ID和购买的数量
        $id_stock = O_goods::select('sku_id','stock')->where('order_id',$order_id->id)->get();
        foreach($id_stock as $k=>$v)
        {
            $attr = G_sku::select('attr')->where('id',$v->sku_id)->first();
            // 减去商品的库存
            $sku_stock = G_sku::select('stock')->where('id',$v->sku_id)->first();
            $stock = $sku_stock->stock*1 - $v->stock*1;
            $res2 = G_sku::where('id',$v->sku_id)->update(['stock'=>$stock]);
            // 减去收藏在购物车中的库存 如果结果小于或等于0 删除该条记录 否则更新购物车中收藏的数量
            $cart_stock = G_cart::select('stock')->where('attr',$attr->attr)->first();
            $c_stock = $cart_stock->stock*1 - $v->stock;
            if($c_stock<=0)
            {
                $res3 = G_cart::where('attr',$attr->attr)->where('user_id',session('user_id'))->delete();
                if($res && $res1 && $res2 && $res3){
                    DB::commit();
                }else{
                    DB::rollBack();
                }
            }
            else
            {
                $res3 = G_cart::where('attr',$attr->attr)->where('user_id',session('user_id'))->update(['stock'=>$c_stock]);
                if($res && $res1 && $res2 && $res3){
                    DB::commit();
                }else{
                    DB::rollBack();
                }
            }
            
        }
        
        
    }

    public function test(Request $req)
    {
        dd($req->all());
        // Order::where('order_number',$data->out_trade_no)->update(['pay_status'=>'1']);
                    $order_id = Order::select('id')->where('order_number',$data->out_trade_no)->first();
                    // O_goods::where('order_id',$order_id->id)->update(['pay_status'=>'1']);
    }
}
