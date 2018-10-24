<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // 权限管理
    public function competence()
    {
        return view('admin.competence');
    }

    // 添加管理
    public function add()
    {
        return view('admin.competence_add');
    }

    // 管理员列表
    public function list()
    {
        $role = Role::get();
        return view('admin.list',[
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

    // 个人信息
    public function info()
    {
        $data = Admin::getInfo();
        return view('admin.info',[
            'data'=>$data
        ]);
    }
}
