<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class G_image extends Model
{
    // 指定表
    protected $table = 'goods_image';
    // 白名单
    protected $fillable = ['goods_id','path','bg_path','md_path','sm_path'];
    // 不更新时间
    public $timestamps = false;
}
