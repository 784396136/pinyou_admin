<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Session\Store;
use Image;

class Brand extends Model
{
    // 指定表
    protected $table = 'brand';
    // 白名单
    protected $fillable = ['brand_name','logo','domestic','thumbnails','cate_id'];
    // 不更新时间
    public $timestamps = false;

    // 获取所有
    public function getAll()
    {
        $data = Brand::get();
        $n = Brand::where('domestic',1)->count();
        $w = Brand::where('domestic',0)->count();
        return [
            'data'=>$data,
            'n'=>$n,
            'w'=>$w,
        ];
    }

    // 添加
    public function add($data)
    {
        // 判断是否重复 （判断品牌名、海内外、分类ID）
        $r = Brand::where('brand_name',$data['brand_name'])->where('domestic',$data['domestic'])->where('cate_id',$data['cate_id'])->first();
        if($r)
        {
            return false;
        }
        else
        {
            if(isset($data['logo']) && $data['logo']!=''){
                $old_path = $data['logo']->path();
                $data['logo'] = '/uploads/'.$data['logo']->store('brand/'.date('Ymd'));
                // 生成缩略图名
                $name = 'sm_'.substr(strrchr($data['logo'],'/'),1);
                $path = public_path('uploads/brand/thumbnails/'.date('Ymd'));
                if(!is_dir($path))
                {
                    mkdir($path,0777,true);
                }
                $img = Image::make($old_path);
                $img->resize(103,52);
                $img->save($path.'/'.$name);
                $data['thumbnails'] = '/uploads/brand/thumbnails/'.date('Ymd').'/'.$name;
            }

            $model = new self;
            $model->fill($data);
            $res = $model->save();
            return $res;
        }
            
    }

    // 根据ID获取品牌
    public function getById($id)
    {
        $data = self::where('cate_id',$id)->get();
        return $data;
    }
}
