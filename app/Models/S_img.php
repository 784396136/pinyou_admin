<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class S_img extends Model
{
     // 指定表
     protected $table = 'sku_image';
     // 白名单
     protected $fillable = ['sku_id','path','sm_path','md_path','bg_path'];
     // 不更新时间
     public $timestamps = false;
}
