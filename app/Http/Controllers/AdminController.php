<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\Models\Role;
use App\Models\Privilege;

class AdminController extends Controller
{
    // 修改密码
    public function changePwd(Request $req)
    {
        // dd($req->all());
        $model = new Admin;
        $model->changePwd($req->all());
    }

    // 权限管理
    public function competence()
    {
        $model = new Role;
        $data = $model->getInfo();
        return view('admin.competence',[
            'data'=>$data
        ]);
    }

    // 添加权限
    public function cpAdd()
    {
        $model = new Privilege;
        $data = $model->tree();
        $info = Admin::getAllInfo();
        return view('admin.competence_add',[
            'data'=>$data,
            'info'=>$info
        ]);
    }

    public function doCpAdd(Request $req)
    {
        $role = new Role;
        $role->add($req->all());
    }

    // 修改权限
    public function cpEdit($id)
    {
        $privilege = new Privilege;
        $data = $privilege->tree();
        $model = new Role;
        $o_data = $model -> getOne($id);
        $info = Admin::getAllInfo();
        return view('admin.competence_edit',[
            'o_data'=>$o_data,
            'info'=>$info,
            'data'=>$data,
        ]);
    }

    public function doCpEdit(Request $req,$id)
    {
        $role = new Role;
        $role->up($req->all(),$id);
        return redirect()->route('AdminCompetence')->with('success', '修改成功!')->withInput();
    }

    // 删除权限
    public function cpDel(Request $req)
    {
        $role = new Role;
        $role->del($req->all()['id']);
    }

    // 管理员列表
    public function list()
    {
        $model = new Role;

        $role = $model->getInfo();
        // 获取管理员的总个数
        $sum = 0;
        foreach($role as $r)
        {
            $sum += $r->count;
        }

        // 获取所有管理员
        $data = Admin::getAllInfo();
        return view('admin.list',[
            'data'=>$data,
            'sum'=>$sum,
            'role'=>$role
        ]);
    }

    // 添加管理员
    public function adminAdd(AdminRequest $req)
    {
        $res = Admin::add($req->all());
        if($res)
        {
            return redirect()->route('AdminList');
        }
    }

    // 禁用管理员
    public function stop(Request $req)
    {
        $id = $req->id;
        Admin::editStatus($id,0);
        return redirect()->route('AdminList');
    }

    // 开启管理员
    public function start(Request $req)
    {
        $id = $req->id;
        Admin::editStatus($id,1);
        return redirect()->route('AdminList');
    }

    // 删除管理员
    public function del(Request $req)
    {
        $data = $req->all();
        Admin::delAdmin($data['id']);
    }

    // 个人信息
    public function info()
    {
        $data = Admin::getInfo();
        return view('admin.info',[
            'data'=>$data
        ]);
    }
}
