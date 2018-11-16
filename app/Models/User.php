<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Hash;

class User extends Model
{
    // 指定表
    protected $table = 'user';

    // 登录
    public function login($data)
    {
        $res = User::where('username',$data['username'])->first();
        if($res)
        {
            if(Hash::check($data['password'],$res->password))
            {
                session([
                    'user_id'=>$res->id,
                    'user_name'=>$res->username,
                ]);
                return 1;
            }
            else
            {
                return 2;
            }
        }
        else
        {
            return 3;
        }
    }
}
