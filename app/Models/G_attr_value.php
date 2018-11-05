<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class G_attr_value extends Model
{
    // 指定表
    protected $table = 'goods_attr_value';
    // 白名单
    protected $fillable = ['goods_id','name_id','attr_value'];
    // 不更新时间
    public $timestamps = false;
}
