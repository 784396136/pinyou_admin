<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    // 会员列表
    public function list()
    {
        return view('member.list');
    }

    // 等级管理
    public function grading()
    {
        return view('member.grading');
    }

    // 会员记录管理
    public function record()
    {
        return view('member.record');
    }
}
