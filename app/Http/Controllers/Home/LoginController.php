<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Flc\Dysms\Client;
use Flc\Dysms\Request\SendSms;


class LoginController extends Controller
{
    // 显示
    public function login()
    {
        return view('index.login.login');
    }

    // 登录
    public function dologin(Request $req)
    {
        $data = $req->all();
        $user = new User;
        $res = $user->login($data);
        if($res==1)
        {
            return redirect()->route('HomeIndex');
        }
        elseif($res==2)
        {
            return redirect()->route('HomeLogin')->with('error','密码错误!')->withInput();
        }
        elseif($res==3)
        {
            return redirect()->route('HomeLogin')->with('error','用户名不存在!')->withInput();
        }
    }

    // 注册
    public function register()
    {
        return view('index.login.register');
    }

    public function doregister(Request $req)
    {
        $data = $req->all();
    }

    // 发送手机验证码
    public function sendCode()
    {
        // 获取手机号
        $mobile = $_POST['mobile'];
        // 生成六位随机数
        $code = rand(100000,999999);
        // 保存到session中
        session(['mobile_code'=>$code]);


        $config = [
            'accessKeyId'=>'LTAICbwvUQPe9RCq',
            'accessKeySecret' =>'TcWWs3fIjqIXQkbAY1amVs7sPeH3XZ',
        ];
        
        $client  = new Client($config);
        $sendSms = new SendSms;
        $sendSms->setPhoneNumbers($mobile);
        $sendSms->setSignName('权世界');
        $sendSms->setTemplateCode('SMS_136485121');
        $sendSms->setTemplateParam(['code' => $code]);
        }
}
