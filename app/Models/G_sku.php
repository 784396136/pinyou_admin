<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class G_sku extends Model
{
    // 指定表
    protected $table = 'goods_sku';
    // 白名单
    protected $fillable = ['goods_id','sku_name','stock','price'];
    // 不更新时间
    public $timestamps = false;

    public function attr_name()
    {
        return $this->hasMany(G_attr_name::class,'goods_id','goods_id')->with('get_val');
    }

    public function sku_img()
    {
        return $this->hasMany(S_img::class,'sku_id','id');
    }

    public function goods_info()
    {
        return $this->hasMany(Goods::class,'id','goods_id');
    }

    // ajax请求数据
    public function getInfo($goods_id,$attr)
    {
        $id = self::select('id')
                    ->where('goods_id',$goods_id)
                    ->where('attr',$attr)
                    ->first()
                    ->toArray();
        return $id;
    }
}
