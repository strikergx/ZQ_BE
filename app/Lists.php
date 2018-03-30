<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Article;


class Lists extends Model
{
    protected $table = 'lists';

    protected $primaryKey = 'id';

    public $timestamps = false;

    public function show()
    {
        $db = Lists::where('uid',0)
            ->orderBy('order')
            ->get();
        if (!$db ->isEmpty()){
            $data = array();
            for ($i = 0;$i < sizeof($db);$i++)
            {
                $data[$i]['column'] = $db[$i]['name'];
                $data[$i]['id'] = $db[$i]['id'];
                $data[$i]['order'] = $db[$i]['order'];
                $lists = Lists::where('uid',$db[$i]['id'])
                    ->orderBy('order')
                    ->get();
                for ($j = 0;$j < sizeof($lists);$j++)
                {
                    $data[$i]['childColumn'][$j]['name'] = $lists[$j]['name'];
                    $data[$i]['childColumn'][$j]['uid'] = $lists[$j]['uid'];
                    $data[$i]['childColumn'][$j]['order'] = $lists[$j]['order'];
                    $data[$i]['childColumn'][$j]['id'] = $lists[$j]['id'];
                }
            }
            $msg['code'] = 0;
            $msg['res'] = $data;
            return $msg;
        }else{
            $err_msg['code'] = 1;
            $err_msg['msg'] = '栏目为空';
            return $err_msg;
        }


    }

    public function del($data)
    {
        $list = Lists::where('id',$data['id'])
            ->first();
        $send['id'] = $list->id;
        $send['uid'] =$list->uid;
        Article::_del($send);
        if(sizeof($list) != 0) {
            if ($list['uid'] == 0){
                $res = Lists::where('uid',$data['id'])
                    ->delete();
                $res = Lists::where('id',$data['id'])
                    ->delete();
                if($res){
                    $msg['code'] = 0;
                    $msg['msg'] = '删除成功';
                    return $msg;
                }else{
                    $err_msg['code'] = 3;
                    $err_msg['msg'] = '操作失败请重试';
                    return $err_msg;
                }
            }else{
                $lists = Lists::where('uid',$list['uid'])
                    ->get();
                if(!$lists -> isEmpty()){
                    for($i = 0;$i < sizeof($lists) ; $i++)
                    {
                        if ($lists[$i]['order'] > $list['order']){
                            Lists::where('id',$lists[$i]['id'])
                                ->update(['order' => ($lists[$i]['order']-1)]);
                        }
                    }
                    $res = Lists::where('id',$data['id'])
                        ->delete();
                    if($res){
                        $msg['code'] = 0;
                        $msg['msg'] = '删除成功';
                        return $msg;
                    }else{
                        $err_msg['code'] = 3;
                        $err_msg['msg'] = '操作失败请重试';
                        return $err_msg;
                    }
                }else{
                    $err_msg['code'] = 3;
                    $err_msg['msg'] = '操作失败请重试';
                    return $err_msg;
                }
            }
        }else{
            $err_msg['code'] = 2;
            $err_msg['msg'] = '栏目不存在';
            return $err_msg;
        }

    }

    public function edit($data)
    {
        $res = Lists::where('id',$data['id'])
            ->get();
        if ( sizeof($res) != 0) {
            $db = Lists::where('id' , $data['id'])
                ->update(['name' => $data['name'] , 'order' => $data['order'] ]);
            if ($db) {
                $msg['code'] = 0;
                $msg['msg'] = '更改成功';
                return $msg;
            } else {
                $err_msg['code'] = 3;
                $err_msg['msg'] = '未做出改变';
                return $err_msg;
            }
        } else {
            $err_msg['code'] = 2;
            $err_msg['msg'] = '被修改的栏目不存在';
            return $err_msg;
        }
    }

    public function add($data)
    {
        $max = Lists::where('uid',0)
            ->max('id');
        //dd($max);
        if ($data['uid'] == 0){
            return $this -> addFa($data);
        } elseif ($data['uid'] > 0 && $data['uid'] <= $max)
        {
            return $this -> addSon($data);
        } else {
            $err_msg['code'] = 2;
            $err_msg['msg'] = '父栏目不存在';
            return $err_msg;
        }

    }

    public function addFa($data)
    {
        $max = Lists::where('uid',0)
            ->max('order');
        if ($data['order'] > 0 && $data['order'] <= ( $max + 1 )){
            $db = Lists::where('uid',$data['uid'])
                ->orderBy('order')
                ->get();
            for ($i = 0;$i < sizeof($db);$i++){
                if ($db[$i]['order'] >= $data['order']){
                    Lists::where('id' , $db[$i]['id'])
                        ->update(['order' => ($db[$i]['order']+1)]);
                }
            }
            Lists::insert(['name' => $data['column']  , 'order' => $data['order'] , 'uid'=> $data['uid']]);
            $list = Lists::where('order',$data['order'])
                ->where('uid',$data['uid'])
                ->first();
            if(sizeof($list) != 0){
                $msg['code'] = 0;
                $msg['msg'] = '添加栏目成功';
                $msg['listid'] = $list['id'];
                return $msg;
            }else{
                $err_msg['code'] = 3;
                $err_msg['msg'] = '操作失败请重试';
                return $err_msg;
            }

        }else{
            $err_msg['code'] = 2;
            $err_msg['msg'] = '插入位置不存在';
            return $err_msg;
        }

    }

    public function addSon($data)
    {
        $max = Lists::where('uid',$data['uid'])
            ->max('order');
        if ($data['order'] > 0 && $data['order'] <= ( $max + 1 )){
            $db = Lists::where('uid',$data['uid'])
                ->orderBy('order')
                ->get();
            for ($i = 0;$i < sizeof($db);$i++){
                if ($db[$i]['order'] >= $data['order']){
                    Lists::where('id' , $db[$i]['id'])
                        ->update(['order' => ($db[$i]['order']+1)]);
                }
            }
            Lists::insert(['name' => $data['column']  , 'order' => $data['order'] , 'uid'=> $data['uid']]);
            $list = Lists::where('order',$data['order'])
                ->where('uid',$data['uid'])
                ->first();
            if($list){
                $msg['code'] = 0;
                $msg['msg'] = '添加栏目成功';
                $msg['listid'] = $list['id'];
                return $msg;
            }else{
                $err_msg['code'] = 3;
                $err_msg['msg'] = '操作失败请重试';
                return $err_msg;
            }

        }else {
            $err_msg['code'] = 2;
            $err_msg['msg'] = '插入位置不存在';
            return $err_msg;
        }
    }



}