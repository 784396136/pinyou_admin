<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InfoController extends Controller
{
    // 留言列表
    public function guestbook()
    {
        return view('info.guestbook');
    }

    // 意见反馈
    public function feedback()
    {
        return view('info.feedback');
    }
}
