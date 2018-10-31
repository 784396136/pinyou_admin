<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    // 指定表名
    protected $table = 'seller';

    // 获取所有
    public static function getAll()
    {
        $data = Seller::where('status','=','0')
                ->get(['id','shop_name','firm','contact','introduce','created_at']);
        $count = Seller::where('status','=','0')
                ->count();
        return [
            'data'=>$data,
            'count'=>$count
        ];
    }

    // 获取一条
    public function getOne($id)
    {
        $data = Seller::where('id',$id)
                ->first();
        return $data;
    }

    // 审核成功
    public function reviewed($id)
    {
        DB::update("UPDATE you_seller set status = 1 WHERE id = ?",[$id]);
    }

    // 审核失败
    public function fail($id)
    {
        DB::delete("DELETE FROM you_seller WHERE id = ?",[$id]);
    }
}
