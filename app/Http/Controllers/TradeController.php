<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TradeController extends Controller
{
    // 交易信息
    public function payInfo()
    {
        return view('trade.transaction');
    }

    // 交易订单（图）
    public function order_Chart()
    {
        return view('trade.Order_Chart');
    }

    // 订单管理
    public function orderform()
    {
        return view('trade.orderform');
    }

    // 交易金额
    public function amounts()
    {
        return view('trade.amounts');
    }

    // 订单处理
    public function order_handling()
    {
        return view('trade.order_handling');
    }

    // 退款管理
    public function refund()
    {
        return view('trade.refund');
    }
}
