<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seller;

class IndexController extends Controller
{
    //
    public function index()
    {
        $data = Seller::getAll();
        session(['shop_count'=>$data['count']]);
        return view('index');  
    }

    public function home()
    {
        return view("home");
    }
}
