<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Admin;
use Hash;

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
        // 获取表单中的所有数据
        $data = $req->all();

        $user = Admin::where('name',$req->name)->first();

        if($user)
        {
            if(Hash::check($req->password,$user->password))
            {
                session([
                    'admin_id'=>$user->id,
                    'admin_name'=>$user->name
                ]);
                return redirect()->route('index');
            }
        }
    }
}
