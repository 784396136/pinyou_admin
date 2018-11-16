<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class O_goods extends Model
{
    // 指定表
    protected $table = 'order_goods';
    // 白名单
    protected $fillable = ['order_id','sku_id','stock'];
}
