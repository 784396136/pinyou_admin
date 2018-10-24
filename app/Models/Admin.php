<?php

namespace App\Models;
use Hash;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Admin extends Model
{
    // 设置白名单
    protected $fillable = ['name','password','role_id'];

    // 获取个人信息
    public static function getInfo()
    {
        return DB::table('admins')
                    ->join('role','admins.role_id','=','role.id')
                    ->where('admins.id','=',session('admin_id'))
                    ->first();
    }

    // 添加管理员
    public static function add($data)
    {
        $data['password'] = Hash::make($data['password']);
        $model = new Admin;
        $model->fill($data);
        return $model->save();
    }

}
