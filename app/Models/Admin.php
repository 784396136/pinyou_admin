<?php

namespace App\Models;
use Hash;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Admin extends Model
{
    // 设置白名单
    protected $fillable = ['name','password','role_id'];

    // 修改密码
    public function changePwd($data)
    {

        
        dd(Admin::find(session('admin_id')),$data);

    }

    // 获取个人信息
    public static function getInfo()
    {
        return DB::table('admins')
                    ->join('role','admins.role_id','=','role.id')
                    ->where('admins.id','=',session('admin_id'))
                    ->first();
    }

    // 获取所有管理员的信息
    public static function getAllInfo()
    {
        return DB::table('admins')
                    ->select('admins.id','admins.name','admins.status','role.role_name','admins.created_at')
                    ->join('role','admins.role_id','=','role.id')
                    ->get();
    }

    // 添加管理员
    public static function add($data)
    {
        $data['password'] = Hash::make($data['password']);
        $model = new Admin;
        $model->fill($data);
        return $model->save();
    }

    // 获取管理员对应角色的个数
    public function getRole()
    {
        return DB::select("SELECT b.role_name,COUNT(b.role_name) count,b.id ,GROUP_CONCAT(a.name) namelist
                            FROM you_admins a 
                            LEFT JOIN you_role b ON a.role_id=b.id
                            GROUP BY b.role_name
                            ORDER BY b.id asc");
    }

    // 修改状态
    public static function editStatus($id,$status)
    {
        DB::update("update you_admins set status = ? where id = ?",[$status,$id]);
    }

    // 删除管理员
    public static function delAdmin($id)
    {
        Admin::where('id',$id)->delete();
    }

}
