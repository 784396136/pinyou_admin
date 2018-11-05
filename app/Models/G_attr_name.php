<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class G_attr_name extends Model
{
    // 指定表
    protected $table = 'goods_attr_name';
    // 白名单
    protected $fillable = ['goods_id','attr_name'];
    // 不更新时间
    public $timestamps = false;
}
