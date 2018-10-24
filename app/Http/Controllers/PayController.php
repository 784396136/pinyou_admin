<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PayController extends Controller
{
    // 账户管理
    public function account()
    {
        return view('pay.account');
    }

    // 支付方式
    public function method()
    {
        return view('pay.method');
    }

    // 支付配置
    public function configure()
    {
        return view('pay.configure');
    }
}
