<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Privilege extends Model
{
    // 指定表名
    protected $table = 'privilege';

    // 获取权限数据
    public function tree()
    {
        return self::_tree(Privilege::get());
    }

    // 获取树状数据
    public static function _tree($data,$parent_id=0,$level=0)
    {
        $res = [];
        foreach($data as $v)
        {
            if($parent_id==$v->parent_id)
            {
                $v->level = $level;
                $level++;
                $v->child = self::_tree($data,$v->id,$level);
                $res[] = $v;
            }
        }
        return $res;
    }
}
