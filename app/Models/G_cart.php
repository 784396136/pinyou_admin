<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\G_sku;
use DB;

class G_cart extends Model
{
    protected $table = 'goods_cart';
    // 白名单
    protected $fillable = ['user_id','sku_name','attr','sm_path','stock','price','goods_id'];
    // 不更新时间
    public $timestamps = false;

    // 加入购物车
    public function add($data)
    {
        $res = self::where('user_id',$data['user_id'])
                    ->where('attr',$data['attr'])
                    ->where('goods_id',$data['goods_id'])
                    ->first();
        if($res)
        {
            $sku_stock = G_sku::select('stock')->where('attr',$res->attr)->where('goods_id',$res->goods_id)->first()->toArray();
            
            $stock = $res->stock + $data['stock'];
            if($stock>$sku_stock['stock'])
            {
                $stock = $sku_stock['stock'];
            }
            self::where('id',$res->id)
                        ->update(['stock'=>$stock]);
            return $res->id;
        }
        else
        {
            $model = new self;
            $model->fill($data);
            $model->save();
            return DB::getPdo()->lastInsertId();
        }
       
    }

    // 获取购物车中的信息
    public function getAll()
    {
        $data = self::where('user_id',session('user_id'))->get();
        $count = self::where('user_id',session('user_id'))->get()->count();
        return [
            'data'=>$data,
            'count'=>$count
        ];
    }

    // 获取购物车中有几件商品
    public function getCount()
    {
        return self::where('user_id',session('user_id'))->count();
    }

    // 获取多条数据
    public function getmultiple($data)
    {
        $goods_id = $data;
        $res = self::select('price')->whereIn('id',$goods_id)->get()->toArray();
        return $res;
    }

    // 加入成功显示的信息
    public function success_info($id)
    {
        $data = self::where('id',$id)->first();
        $attr_name = [];
        $attr_value = [];
        $attr = explode(',',$data->attr);
        // 将拼成的属性分割数组
        foreach($attr as $k=>$v)
        {
            $attr[$k] = explode(':',$attr[$k]);
        }
        // 二次分割
        for($i=0;$i<count($attr);$i++)
        {
            for($j=0;$j<count($attr[$i]);$j++)
            {
                if($j%2==0)
                {
                    $attr_name[] = $attr[$i][$j];
                }
                else
                {
                    $attr_value[] = $attr[$i][$j];
                }
            }
        }
        $name = G_attr_name::select('attr_name')->whereIn('id',$attr_name)->get()->toArray();
        $value = G_attr_value::select('attr_value')->whereIn('id',$attr_value)->get()->toArray();

        // 将查询的结果拼接字符串
        $attr_str = '';
        foreach($name as $k=>$v)
        {
            if($attr_str!='')
            {
                $attr_str .= ','.$name[$k]['attr_name'] .":".$value[$k]['attr_value'];
            }
            else
            {
                $attr_str .= $name[$k]['attr_name'] .":".$value[$k]['attr_value'];
            }
        }
        $data = $data->toArray();
        $data['attr'] = $attr_str;
        return $data;
    }

    // 结算页面
    public function OrderGoods($data)
    {
        $res = [];
        foreach($data['goods'] as $v)
        {
            $res[] = self::where('id',$v)->with('goods_sku')->first()->toArray();
        }
        foreach($res as $k=>$v)
        {
            if($data['stock'][$k]>$res[$k]['goods_sku'][0]['stock'])
            {
                $data['stock'][$k] = $res[$k]['goods_sku'][0]['stock'];
            }
            $res[$k]['stock'] = $data['stock'][$k];
        }
        return $res;
    }

    public function goods_sku()
    {
        return $this->hasMany(G_sku::class,'attr','attr');
    }
}
