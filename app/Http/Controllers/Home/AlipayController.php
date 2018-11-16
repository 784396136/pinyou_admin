<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yansongda\Pay\Pay;

class AlipayController extends Controller
{
    public $config = [
        'app_id'=>'2016091700531217',
        // 通知地址
        
    ];
    // 发起支付
    public function pay()
    {

    }
}
