<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yansongda\Pay\Pay;
use App\Models\Order;
use App\Models\G_cart;
use App\Models\O_goods;
use App\Modesl\G_sku;
use DB;

class AlipayController extends Controller
{
    public $config = [
        'app_id' => '2016091700531217',
        // 通知地址
        'notify_url' => 'http://226588x17i.imwork.net/home/alipay/notify',
        // 跳回地址
        'return_url' => 'http://226588x17i.imwork.net/home/alipay/return',
        // 支付宝公钥
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwdZYqwin5jfltN0y1tMDrt8Mj2NcyY3DVn1H3p6Er9IFZ5IMmPk4p16BLyrma7EuMDSmerCIndvmqjOTPtXPmxknf4wK8IHxyw96yDGm2YDBLTqZZAXYihud/S4iKAJDXyRA7hyxnkndc0ac7hNzx9UtnpY0l9wk/Pph5hDdTfCPRcb16qTzDimTaChYSRBc1d3PI9yuBIiAJHdguhwHYfNcw6Mo+F3sauaIBWFqaXf5bIOUSHF2p8w6rvcaQxWiJFxLjqNqE9V3Pnou/cYnyZvtTZyMLSuai65NrLvV1JejOD1CpsDN/t1Es7kM84qkGgzOyffUyd0I8JQ7UzV18QIDAQAB',
        // 商户应用密钥
        'private_key' => 'MIIEpQIBAAKCAQEA1owH7Iw8j0NK0uG1DS0m9gAS4KuvvUyUadCgw/vburhtvGtrCO01114esIGinbW40WH5wqwrKh9QFtsPOys3WGb5x2wtGKBC9K0UXDjnmegRHL234hRtHmwogwaKm2FITGVEF0LHdqdTCzsuih9zWnH9OzBwTlcLzkfpinP/MhDZoY1Vv4xLxQMvCD27F6hAD8zle3vGhhxC+o0JVpm7bHl6tW02RMvwf8kbrnidnssjjDueNSKN54QB2a+yXNyaKy7T5Vh0kPgpHOlA4/52HlGpYwhf0++rbFFQ7vir8A1NOLVu1Vd/Kw0QyY3V2TOJDuZkZnXjXiqHQ+NQsuLGJQIDAQABAoIBAQC2EnYzD7vhFIluN2+PtA7JW7ypf+oPKusUdaHJUHbjmdo+uaZHGA/GKrC+t/UKBArJXm04ASZMg/BSxSrC2uUIF7PHwozuxiqsPCn4La6WlTPYgUSJDy6fT8h9kVKVlFRnyNSlLN3bWxqFgH75ZsFdMzllPrFAOmzhbXPLNK+QiuBslTYGYyXGyx/eXgbyFnfxNY9HLcqqqrZKEQedKQ/LUTOcpie/xsI7l5bHFZNc7S2SV61qeXo/vM8emagMvBX31Xemh9+TJN4thLVPHwOWlu+/toUXPtiUYgqyDB1WIrIrxfSrhTqacgX/DCf2zzjv22uMmX7ZlZANFV/mIwXNAoGBAOwsCNcgIP/Hzen88o/lcYJEUN99QLbURodUPcZvzmjF5d1OpumcQcZkWzQH+NcooNxA+fIeT2caFPuyXEFQgEDg4/7ifZuMRlVOCw7VPuwdkUlcVuDMFOsijNe6xx9kQnGbpnkO72qvF8voxJa2jqx+NFjrqEqIjqJLrlg212SfAoGBAOiPN5+Ml6nccMADX1w5zoWtfCjE7vGW64FFn8D+JXKxxC0FqdsybA+4vmdJNKriHC6diXgx/LCC5gTj+ipJNLpy41HS2nOOa7zF+cSLxVvF7ILGbk72rT4zHkj5ZGso9pRZX0BMbOKHxCnGm9IJjqm1EhUqBGpkBDdnmZcfF/q7AoGAf7PLz+8aiNQUPrq8uhw5xVOFW2NR08pynIhrotogBT1E7uaxkE4irtDjE/5fio/4c0BbJpVHIBvVTsgB5HtP7kTsY406mBpAia3agtnB3VCbl8xrWcBga0hSWfAv7YR7/QxJ9tmhkdE9j8+8RTZPbWwMiCxc4nh2j8FWc3KsA0cCgYEA4UuttVG8tAAs8rfRsEUIQBTbjZuLaFyu9mN+6rbLjJuO05cDAKmOaoStYN5YuZundbmErf6vMEj/kYlSl5ioDmCyvFgq7Xvx/8VDvRczMT9Da0XVI4ZyOynGkyeYEwByMTGLx3zCl4qzjU0tM4Oyw9H5HKvB71fJhetFrlOfJXUCgYEAq1w/NPE91wJCUiUzM+weiAFZ8sK4Jlj8BtulKFfg+74zqmK+Xwvu4vVdpnFXUhMc2Mcn83A4tziFW3yFNGl5DC+3uM+Tc7jiowHC1cF5rRk/m7MhrLGqXk2xyI3latHYnl/9XLXOtk9V1+BC5pbrcZ4FpZOa6HN04oBzqddTYd0=',
        // 沙箱模式（可选）
        'mode' => 'dev',
    ];
    // 发起支付
    public function pay()
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
        // 将订单保存到数据库
        $data = $_POST;
        $data['order_number'] = $order_num;
        $data['total_price'] = $sum_price;
        $m_order->add($data);
        // 生成支付信息
        $order = [
            'out_trade_no' => $order_num,    // 本地订单ID
            'total_amount' => $sum_price,    // 支付金额
            'subject' => $order_num, // 支付标题 (此处用订单号当为标题)
        ];
        $alipay = Pay::alipay($this->config)->web($order);
        $alipay->send();
    }

    // 支付完成跳回页面
    public function return()
    {
        $data = Pay::alipay($this->config)->verify(); // 是的，验签就这么简单！
        return view('index.paysuccess',[
            'type'=>2,
            'price'=>$data->total_amount
        ]);
    }

    // 接收支付完成的通知
    public function notify()
    {
        $alipay = Pay::alipay($this->config);
        try{
            $data = $alipay->verify(); // 是的，验签就这么简单！
            // 这里需要对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
          
                // 开启事务
                DB::beginTransaction();
                        
                // 将订单状态修改为已提交
                $res = Order::where('order_number',$data->out_trade_no)->update(['pay_status'=>'1']);
                file_put_contents('order',$data->out_trade_no);
                $order_id = Order::select('id')->where('order_number',$data->out_trade_no)->first();
                $res1 =  O_goods::where('order_id',$order_id->id)->update(['pay_status'=>'1']);
                // 获取付款商品的ID和购买的数量
                $id_stock = O_goods::select('sku_id','stock')->where('order_id',$order_id->id)->get();
                $count = 0;
                foreach($id_stock as $k=>$v)
                {
                    $count += $k;
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
                        file_put_contents('a','foreach 提交');
                        DB::commit();
                    }else{
                        file_put_contents('a','foreach 撤回');
                        DB::rollBack();
                    }
                }
                file_put_contents('count',$count);
                // 事务判断
                if($res && $res1){
                    file_put_contents('abc','提交了');
                    DB::commit();
                }else{
                    file_put_contents('abc','撤回');
                    DB::rollBack();
                }

        } catch (\Exception $e) {
            echo '失败：';
            var_dump($e->getMessage()) ;
        }
        // 返回响应
        $alipay->success()->send();
    }
}
