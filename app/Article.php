<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


class Article extends Model
{

    protected $table = 'article';

    public function add($data)
    {
        $created_at = time();
        $data['created_at'] = $created_at;
        $id = DB::table('article')
            ->insertGetId($data);
        if ($id) {
            $msg['code'] = 0;
            $msg['id'] = $id;
            $msg['msg'] = '添加文章成功';
            return $msg;
        }else{
            $err_msg['code'] = 2;
            $err_msg['msg'] = '添加文章失败，请重试';
        }

    }


    public function del($data)
    {
        $db = DB::table('article')
            ->where('id',$data['id'])
            ->update(['is_del' => 1]);
        if($db){
            $msg['code'] = 0;
            $msg['msg'] = '添加到回收站成功';
            return $msg;
        }else{
            $err_msg['code'] = 2;
            $err_msg['msg'] = '删除失败，请重试';
            return $err_msg;
        }

    }

    public function dele($data)
    {
        $db = DB::table('article')
            ->where('id',$data['id'])
            ->delete();
        if($db){
            $msg['code'] = 0;
            $msg['msg'] = '删除成功';
            return $msg;
        }else{
            $err_msg['code'] = 2;
            $err_msg['msg'] = '删除失败，请重试';
            return $err_msg;
        }

    }

    public static function _del($data)
    {
        if ($data['uid'] != 0){
            DB::table('article')
                ->where('list_id',$data['id'])
                ->update(['is_del' => 1]);
        }else{
            $lists = DB::table('lists')
                ->where('uid',$data['id'])
                ->get();
            for ($i = 0 ; $i < sizeof($lists) ; $i++){
                DB::table('article')
                    ->where('list_id',$lists[$i]->id)
                    ->update(['is_del' => 1]);
            }
        }
    }


    public function edit($data)
    {
        $created_at = time();
        $data['created_at'] = $created_at;
        $list = DB::table('lists')
            ->where('id',$data['list_id'])
            ->get();
        if(sizeof($list) == 0)
        {
            $err_msg['code'] = 2;
            $err_msg['msg'] = '目标栏目不存在，请重试';
            return $err_msg;
        }
        $art['title'] = $data['title'];
        $art['author'] = $data['author'];
        $art['source'] = $data['source'];
        $art['list_id'] = $data['list_id'];
        $art['content'] = $data['content'];
        $db = DB::table('article')
            ->where('id',$data['id'])
            ->update($art);
        if ($db) {
            $msg['code'] = 0;
            $msg['id'] = $data['id'];
            $msg['msg'] = '修改文章成功';
            return $msg;
        }else{
            $err_msg['code'] = 3;
            $err_msg['msg'] = '修改文章失败，请重试';
            return $err_msg;
        }
    }

    public function show($data)
    {
        $db = DB::table('article')
            ->where('id',$data['id'])
            ->get();
        $cate = DB::table('lists')
            ->where('id', $db[0] -> list_id)
            ->select('id', 'name', 'uid')
            ->first();
        $cate_father = DB::table('lists')
            ->where('id', $cate -> uid)
            ->select('id', 'name')
            ->first();
        $cate_list = DB::table('lists')
            ->where('uid', $cate -> uid)
            ->select('name', 'id')
            ->get() -> toArray();
        foreach ($cate_list as $k => $v) {
            if($cate_list[$k] -> id == $cate -> id) {
                unset($cate_list[$k]);
            }
        }
        sort($cate_list);
        if (!$db -> isEmpty()) {
            $msg['code'] = 0;
            $msg['cate'] = $cate;
            $msg['cate_father'] = $cate_father;
            $msg['cate_other'] = $cate_list;
            $msg['article']['title'] = $db[0] -> title;
            $msg['article']['content'] = $db[0] -> content;
            $msg['article']['author'] = $db[0] -> author;
            $msg['article']['source'] = $db[0] -> source;
            $msg['article']['created_at'] = date('Y-m-d H:m' , $db[0] -> created_at);
            return $msg;
        } else {
            $err_msg['code'] = 2;
            //文章不存在的情况下
            $err_msg['msg'] = '操作失败，请重试';
            return $err_msg;
        }

    }

    public function showHeader($data)
    {
        //data listid是分类id //应该是传入子级 查出父级
        $cate = DB::table('lists')
            ->where('id', $data['list_id'])
            ->select('name','id', 'uid')
            ->first();

        $cate_father = DB::table('lists')
            ->where('id', $cate->uid)
            ->select('name', 'id')
            ->first();
        $cate_list = DB::table('lists')
            ->where('uid', $cate -> uid)
            ->select('name', 'id')
            ->get() -> toArray();
        foreach ($cate_list as $k => $v) {
            if($cate_list[$k] -> id == $cate -> id) {
                unset($cate_list[$k]);
            }
        }
        sort($cate_list);

        $db = DB::table('article')
            ->where('list_id',$data['list_id'])
            ->orderBy('created_at','desc')
            ->select('title','id')
            ->get();
        $msg['code'] = 0;
        $msg['cate_info'] = $cate;
        $msg['cate_other'] = $cate_list;
        $msg['cate_father_info'] = $cate_father;
        if(!$db -> isEmpty()){
            if (sizeof($db) > 6)
            {
                for($i = 0 ; $i < 6 ; $i++)
                {
                    $msg['title'][$i]['title'] = $db[$i]->title;
                    $msg['title'][$i]['id'] = $db[$i]->id;
                }
            } else {
                for($i = 0 ; $i < sizeof($db) ; $i++)
                {
                    $msg['title'][$i]['title'] = $db[$i]->title;
                    $msg['title'][$i]['id'] = $db[$i]->id;
                }
            }
            return $msg;
        }else{
            $err_msg['code'] = 2;
            $err_msg['msg'] = '该栏目暂未发表文章';
            $err_msg['cate_info'] = $cate;
            $err_msg['cate_other'] = $cate_list;
            $err_msg['cate_father_info'] = $cate_father;
            return $err_msg;
        }

    }

    public function More($data)
    {
        $db = DB::table('article')
            ->where('list_id',$data['list_id'])
            ->orderBy('created_at','desc')
            ->select('title','id')
            ->get();
        $msg['code'] = 0;
        if(!$db -> isEmpty()){
            for($i = 0 ; $i < sizeof($db) ; $i++)
            {
                $msg[$i]['title'] = $db[$i]->title;
                $msg[$i]['id'] = $db[$i]->id;
            }
            return $msg;
        }else{
            $err_msg['code'] = 2;
            $err_msg['msg'] = '该栏目暂未发表文章';
            return $err_msg;
        }

    }

    public function SiteMov()
    {
        //截取诗联大赛 大学堂 校园联盟中的文章 获取所有可能的分类id
        //增加本站动态那张图片以及上面的第一个文章的内容 //
        //将分类父级id为345的进行遍历出来 再进行收取
        $cat_arr = [3, 4, 5];
        $son_arr = $this -> SearchCategory($cat_arr);
        $cat_arr = array_merge($cat_arr, $son_arr);
        $articles = $this -> whereIn('list_id', $cat_arr) -> limit(7) -> get();
        return $articles;
    }

    public function NewExpress()
    {
        $cat_arr = [3];
        $son_arr = $this -> SearchCategory($cat_arr);
        $cat_arr = array_merge($cat_arr, $son_arr);

        $articles = $this -> where('list_id', $cat_arr) -> limit(7) -> get();
        return $articles;
    }

    public function CateArticle($catid)
    {
        $article = $this -> where('list_id', '=', $catid) -> get() -> toArray();
        return $article;
    }

    private function SearchCategory($father_arr)
    {
        $son_arr = [];
        foreach ($father_arr as $father_item) {
            $res = DB::table('lists')
                ->where('uid', $father_item)
                ->select('id', 'uid')
                ->get();
            foreach($res as $son_item) {
                if(!in_array($son_item -> id, $son_arr)) {
                    array_push($son_arr, (int)($son_item -> id));
                }
            }
        }

        return $son_arr;
    }


}