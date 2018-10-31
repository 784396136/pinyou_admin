<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seller;
use App\Models\Mail;

class ShopController extends Controller
{
    // 店铺列表
    public function list()
    {
        return view('shop.list');
    }

    // 店铺审核
    public function audit()
    {
        $data = Seller::getAll();
        return view('shop.audit',[
            'data'=>$data
        ]);
    }

    // 审核详情页
    public function detailed($id)
    {
        $seller = new Seller;
        $data = $seller->getOne($id);
        return view('shop.detailed',[
            'data'=>$data
        ]);
    }

    // 审核通过
    public function pass(Request $req)
    {
        $pass = false;

        $data = $req->all();
        $id = $data['id'];
        $res = Seller::where('id',$id)->first();

        // 判断是否有信息  没有就是通过 有就是没通过
        if(!isset($data['reason']))
        {
            $data['reason'] = "恭喜您成功通过本站的审核,能在本站开点啦~<br><a href='http://localhost:4545/login'>点击跳转登录</a>";
            $pass = true;
        }

        // 发送邮件
        $mail = new Mail;
        $r = $mail->send('店铺激活',$res->contact_email,$res->contact,$data['reason']);
        if($r)
        {
            $seller = new Seller;
            if($pass)
            {
                $seller->reviewed($id);
            }
            else
            {
                $seller->fail($id);
            }
        }
    }
}
