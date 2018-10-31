<?php

namespace App\Models;
use App\Models\Admin;
use App\Models\Role;
use Hash;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    // 登录
    public static function dologin($req)
    {
        $user = Admin::where('name',$req->name)->first();

        if($user)
        {
            if(Hash::check($req->password,$user->password))
            {
                if($user->status==1)
                {
                    $role_name = Role::where('id',$user->role_id)
                                    ->first(['role_name']);
                    session([
                        'admin_id'=>$user->id,
                        'admin_name'=>$user->name,
                        'role_name'=>$role_name->role_name
                    ]);
                    return 1;
                }
                else
                {
                    return 3;
                }
            }
            else
            {
                return 4;
            }
        }
        else
        {
            return 2;
        }
    }
}
