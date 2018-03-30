<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Bread extends Model
{
    public function FetchBread($art_id)
    {
        $art = DB::table('article')
            -> where('id', $art_id)
            -> get();
        return $art;
    }
    public function Bread2($cid)
    {
        //获取所有当前父分类下的分类
        $curr = DB::table('lists')
            -> where('id', $cid)
            -> select('id', 'uid')
            -> first();
        //获取所有UID为当前UID的分类
        
        $now = DB::table('lists')
            -> where('uid', $curr -> uid)
            -> select('id', 'uid', 'name', 'order')
            -> get();
        
        return $now;
    }

    public function BreadFather($cid)
    {
        $uid = DB::table('lists')
            -> where('id' ,$cid)
            -> select('uid', 'id')
            -> first();
        $father = DB::table('lists')
            -> where('id', $uid -> uid)
            -> select('id', 'name')
            -> first();
        return $father;
    }
}
