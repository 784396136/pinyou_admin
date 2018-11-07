<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\G_image;
use App\Models\G_sku;
use App\Models\G_attr_name;
use App\Models\G_attr_value;
use Image;
use DB;

class Goods extends Model
{
    // 指定表
    protected $table = 'goods';
    // 设置白名单
    protected $fillable  = ['goods_name','subtitle','logo','thumbnails','content','brand_id','cat1','cat2','cat3','seller_id'];

    // 获取商品
    public function getShops($cat_id)
    {
        $data = self::where('cat1',$cat_id)->orwhere('cat2',$cat_id)->orwhere('cat3',$cat_id)->get();
        return $data;
    }

    // 添加
    public function add($data)
    {
        if(isset($data['logo']) && $data['logo']!='')
        {
            $seller_path = base_path('../laravel-seller/public/uploads/');
            $old_path = $data['logo']->path();
            $data['logo'] = '/uploads/'.$data['logo']->store('goods/logo/'.date('Ymd'));
            // 生成缩略图名
            $name = substr(strrchr($data['logo'],'/'),1);
            $s_name = 'sm_'.$name;
            $path = public_path('/uploads/goods/logo/thumbnails/'.date('Ymd'));
            if(!is_dir($path))
            {
                mkdir($path,0777,true);
            }
            if(!is_dir($seller_path.'goods/logo/'.date("Ymd")))
            {
                
                mkdir($seller_path.'goods/logo/'.date("Ymd"),0777,true);
                mkdir($seller_path.'goods/logo/thumbnails/'.date("Ymd"),0777,true);
            }
            $img = Image::make($old_path);
            $img->save($seller_path.'goods/logo/'.date("Ymd").'/'.$name);
            $img->resize(215,276);
            $img->save($path.'/'.$s_name);
            $img->save($seller_path.'goods/logo/thumbnails/'.date("Ymd").'/'.$name);
            $data['thumbnails'] = '/uploads/goods/logo/thumbnails/'.date('Ymd').'/'.$name;
        }
        $data['seller_id'] = session('seller_id');
        $model = new self;
        $model->fill($data);
        $model->save();
        // 获取新插入ID
        $id = DB::getPdo()->lastInsertId();

        // 保存图片
        foreach($data['image'] as $v)
        {
            if($v->isValid())
            {
                $seller_path = base_path('../laravel-seller/public/');
                $im = new G_image;
                $img = [];
                $old_path = $v->path();
                $img['path'] = '/uploads/'.$v->store('goods/'.date("Ymd"));

                // 生成缩略图
                $name = substr(strrchr($img['path'],'/'),1);
                $sm_name = 'sm_'.$name;
                $md_name = 'md_'.$name;
                $bg_name = 'bg_'.$name;
                $path = public_path('/uploads/goods/thumbnails/'.date('Ymd'));
                // 创建文件夹
                if(!is_dir($path))
                {
                    mkdir($path.'/800/',0777,true);
                    mkdir($path.'/400/',0777,true);
                    mkdir($path.'/56/',0777,true);
                }
                if(!is_dir($seller_path.'uploads/goods/'.date("Ymd")))
                {
                    mkdir($seller_path.'uploads/goods/'.date("Ymd"),0777,true);
                    mkdir($seller_path.'uploads/goods/thumbnails/'.date("Ymd").'/800/',0777,true);
                    mkdir($seller_path.'uploads/goods/thumbnails/'.date("Ymd").'/400/',0777,true);
                    mkdir($seller_path.'uploads/goods/thumbnails/'.date("Ymd").'/56/',0777,true);
                }
                $image = Image::make($old_path);
                $image->save($seller_path.'uploads/goods/'.date("Ymd").'/'.$name);
                // 生成大图
                $image->resize(800,800);
                $image->save($path.'/800/'.$bg_name);
                $image->save($seller_path.'uploads/goods/thumbnails/'.date("Ymd").'/800/'.$bg_name);
                $img['bg_path'] = '/uploads/goods/thumbnails/'.date('Ymd').'/800/'.$bg_name;
                // 生成中图
                $image->resize(400,400);
                $image->save($path.'/400/'.$md_name);
                $image->save($seller_path.'uploads/goods/thumbnails/'.date("Ymd").'/400/'.$md_name);
                $img['md_path'] = '/uploads/goods/thumbnails/'.date('Ymd').'/400/'.$md_name;
                // 生成小图
                $image->resize(56,56);
                $image->save($path.'/56/'.$sm_name);
                $image->save($seller_path.'uploads/goods/thumbnails/'.date("Ymd").'/56/'.$sm_name);
                $img['sm_path'] = '/uploads/goods/thumbnails/'.date('Ymd').'/56/'.$sm_name;
                $img['goods_id'] = $id;
                $im->fill($img);
                $im->save();
            }
        }

        // 保存属性
        foreach($data['attr'] as $k=>$v)
        {
            
            $n_attr = new G_attr_name;
            $res = G_attr_name::where('attr_name',$v)->where('goods_id',$id)->first();
            if(!$res)
            {
                $g_attr = [];
                $g_attr['goods_id'] = $id;
                $g_attr['attr_name'] = $v;
                $n_attr->fill($g_attr);
                $n_attr->save();
                $n_id = DB::getPdo()->lastInsertId();   
            }
            else
            {
                $n_id = $res->id;
            }

            // 添加属性值
            $g_value['name_id'] = $n_id;
            $v_attr = new G_attr_value;
            $g_value['goods_id'] = $id;
            $g_value['attr_value'] = $data['attr_value'][$k];
            $v_attr->fill($g_value);
            $v_attr->save();
        }

      
    }
}
