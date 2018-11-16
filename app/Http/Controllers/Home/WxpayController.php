<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yansongda\Pay\Pay;
use Endroid\QrCode\QrCode;
use App\Models\G_cart;
use App\Models\Order;
use App\Models\O_goods;
use App\Models\G_sku;
use DB;

class WxpayController extends Controller
{
    // 基本配置
    protected $config = [
            'app_id' => 'wx426b3015555a46be', // 公众号 APPID
            'mch_id' => '1900009851',
            'key' => '8934e7d15453e97507ef794cf7b0519d',
            'notify_url' => "http://a912218c.ngrok.io/home/wxpay/res",
        ];

    // 显示页面 并支付
    public function index()
    {
        // 生成唯一订单号
        $m_order = new Order;
        $order_num = $m_order->get_orderID();
        // 获取商品价格
        $g_cart = new G_cart;
        $infos = $g_cart->getmultiple($_POST['goods_id']);
        // 保存订单总价
        $sum_price = 0;
        for($i=0;$i<count($infos);$i++)
        {
            // 计算出总价
            $sum_price += $infos[$i]['price'] * $_POST['goods_stock'][$i];
        }
        $order = [
            'out_trade_no' => $order_num,
            'total_fee' => 1, //价格 单位分
            'body' => $order_num,
        ];
        $pay = Pay::wechat($this->config)->scan($order);
        // 将订单保存到数据库
        $data = $_POST;
        $data['order_number'] = $order_num;
        $data['total_price'] = $sum_price;
        $m_order->add($data);
        session(['qrcode_url'=>$pay->code_url]);
        return view('index.pay',[
            'order'=>$order_num,
            'sum_price'=>$sum_price,
        ]);
    }

    // 显示二维码
    public function code(Request $req)
    {
        $qrCode = new QrCode($req->session()->pull('qrcode_url',session('qrcode_url')));
        header('Content-Type: '.$qrCode->getContentType());
        echo $qrCode->writeString();
    }

    // 支付结果
    public function notify()
    {
        $pay = Pay::wechat($this->config);

        try{
            $data = $pay->verify(); // 是的，验签就这么简单！

            
            // 判断是否支付成功
            if($data->result_code == 'SUCCESS' && $data->return_code == 'SUCCESS')
            {
               // 开启事务
                DB::beginTransaction();
                        
                // 将订单状态修改为已提交
                $res = Order::where('order_number',$data->out_trade_no)->update(['pay_status'=>'1']);
                $order_id = Order::select('id')->where('order_number',$data->out_trade_no)->first();
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
                    }
                    else
                    {
                        $res3 = G_cart::where('attr',$attr->attr)->where('user_id',session('user_id'))->update(['stock'=>$c_stock]);
                    }
                    if($res2 && $res3){
                        DB::commit();
                    }else{
                        DB::rollBack();
                    }
                }
                // 事务判断
                if($res && $res1){
                    DB::commit();
                }else{
                    DB::rollBack();
                }
            }
    
        } catch (Exception $e) {
            var_dump( $e->getMessage() );
        }
        // 发送响应
        $pay->success()->send();
    }
}
