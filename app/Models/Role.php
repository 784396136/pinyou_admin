<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    // 指定表名
    protected $table = 'role';
    // 设置白名单
    protected $fillable = ['role_name'];

    // 添加角色
    public function add($data)
    {
        // 先在role表中添加
        $model = new Role;
        $model->fill($data);
        $model->save();
        // 获取新插入ID
        $id = DB::getPdo()->lastInsertId();
        // 添加角色对应的权限
        
        foreach($data['pri_id'] as $v)
        {
            DB::insert("INSERT INTO you_role_privilege (role_id,pri_id) VALUES(?,?)",[$id,$v]);
        }

        if(isset($data['admin']))
        {
            foreach($data['admin'] as $v)
            {
                DB::update("UPDATE you_admins SET role_id = ? WHERE id = ?",[$id,$v]);
            }
        }

    }

    // 获取权限以及对应的用户
    public function getInfo()
    {
        return DB::select("SELECT a.*,COUNT(b.id) count ,GROUP_CONCAT(b.name) namelist
                            FROM you_role a 
                            LEFT JOIN you_admins b ON a.id=b.role_id
                            GROUP BY a.role_name
                            ORDER BY a.id asc");
    }

    // 修改权限查询一条
    public function getOne($id)
    {   
        $data = DB::table('role as r')
                ->select("r.id as role_id","r.role_name",DB::raw("GROUP_CONCAT(you_rp.pri_id) as p_list"),DB::raw("GROUP_CONCAT(you_a.id) as id_list"))
                ->leftJoin('role_privilege as rp',"r.id",'=','rp.role_id')
                ->leftJoin("admins as a","r.id",'=','a.role_id')
                ->where("r.id",'=',$id)
                ->groupBy('a.role_id')
                // ->toSql();
                ->first();

        // 数据去重
        $p_list = explode(',',$data->p_list);
        $data->p_list = array_unique($p_list);
        $id_list = explode(',',$data->id_list);
        $data->id_list = array_unique($id_list);
        return $data;
    }

    // 删除角色
    public function del($id)
    {
        $data = Role::find($id);

        if($data->delete())
        {
            DB::delete("DELETE FROM you_role_privilege WHERE role_id = ?",[$id]);
            DB::update("UPDATE you_admins SET role_id = 0 WHERE role_id = ?",[$id]);
        }

    }

    // 更新
    public function up($data,$role_id)
    {
        $model = new Role;
        $res = $model->fill($data);
        $r = Role::where('id',$role_id)
                ->update(['role_name'=>$res->role_name]);
        if($r)
        {
            DB::table('role_privilege')
                ->where('role_id',$role_id)
                ->delete();

            if(isset($data['pri_id']))
            {
                foreach($data['pri_id'] as $v)
                {
                    DB::insert("INSERT INTO you_role_privilege (role_id,pri_id) VALUES(?,?)",[$role_id,$v]);
                }
            }
            

            $a = DB::table('admins')
                ->where('role_id',$role_id)
                ->update(['role_id'=>0]);

                if(isset($data['admin']))
                {
                    foreach($data['admin'] as $v)
                    {
                        DB::update("UPDATE you_admins SET role_id = ? WHERE id = ?",[$role_id,$v]);
                    }
                }
        }
    }
}
