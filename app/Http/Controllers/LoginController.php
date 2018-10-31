<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Login;

class LoginController extends Controller
{
    // 显示登录视图
    public function login()
    {
        return view('login');
    }

    // 登录
    public function dologin(LoginRequest $req)
    {

        $res =  Login::dologin($req);
        if($res==1)
        {
            return redirect()->route('index');
        }
        elseif($res==2)
        {
            return redirect()->route('login')->with('error', '用户名不存在!')->withInput();
        }
        elseif($res==3)
        {
            return redirect()->route('login')->with('error', '您的账号已被封停!')->withInput();
        }
        elseif($res==4)
        {
            return redirect()->route('login')->with('error', '密码错误!')->withInput();
        }
        
    }
}
