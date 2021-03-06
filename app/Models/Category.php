<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table = 'category';
    protected $fillable = ['cat_name','parent_id','path'];
    public $timestamps = false;

    // 添加
    public function add($data)
    {
        $res = Category::where('parent_id',$data['parent_id'])->where('cat_name',$data['cat_name'])->first();
        if($res)
        {
            echo json_encode(1);
        }
        else
        {
            if($data['parent_id']==0)
            {
                $data['path'] = '-';
            }
            else
            {
                $p = Category::where('id',$data['parent_id'])->first(['path']);

                $data['path'] = $p->path.$data['parent_id'].'-';
            }
            $model = new self;
            $model->fill($data);
            $model->save();
        } 
        

    }

    // 获取上级
    public function getParent($id)
    {
        $data = self::where('id',$id)->first();
        // 转成数组并去空
        $array = array_filter(explode('-',$data->path));
        $array[] = $id;
        // 查询
        $res = self::whereIn('id',$array)->get();
        return $res;
    }

    // 获取所有
    public function getAll()
    {
        $data = Category::get();
        $res = $this->tree($data);
        return $res;
    }

    public function getChild()
    {
        $data = Category::get();
        $res = $this->_tree($data);
        return $res;
    }

    // 获取一级分类和二级分类
    public function get1A2()
    {
        $data = Category::get();
        foreach($data as $k=>$v)
        {
            if(count(explode('-',$v->path))>=4)
            {
                unset($data[$k]);
            }
        }
        $res = $this->tree($data);
        return $res;
    }

    // 获取树状类型
    public function tree($data,$parent_id=0,$level=0)
    {
        static $res = [];
        foreach($data as $v)
        {
            if($v->parent_id==$parent_id)
            {
                $v->level = $level;
                $res[] = $v;
                $this->tree($data,$v->id,$level+1);
            }
        }
        return $res;
    }

    // 获取三维数组
    public function _tree($data,$parent_id=0)
    {
        $res = [];
        foreach($data as $v)
        {
            if($v->parent_id==$parent_id)
            {
                $v->child = $this->_tree($data,$v->id);
                $res[] = $v;
            }
        }
        return $res;
    }
}
