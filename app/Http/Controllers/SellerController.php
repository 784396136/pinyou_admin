<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goods;

class SellerController extends Controller
{
    public function doadd(Request $req)
    {
        $data = $req->all();
        $model = new Goods;
        $model->add($data);
        return redirect("http://localhost:5555/goods/goods");
    }
}
