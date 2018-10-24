<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SystemsController extends Controller
{
    // 系统设置
    public function set()
    {
        return view('systems.set');
    }

    // 栏目设置
    public function column()
    {
        return view('systems.column');
    }

    // 日志设置
    public function log()
    {
        return view('systems.logs');
    }
}
