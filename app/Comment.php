<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function addComment($content, $article, $username, $comment)
    {
        $data['uid'] = $comment;
        $data['comment'] = $content;
        $data['article_id'] = $article;
        $data['user_name'] = $username;
        $data['created_at'] = date("Y:m:d H:i:s", time());
        $data['updated_at'] = date("Y:m:d H:i:s", time());

        $ins = DB::table('comment') -> insertGetId($data);

        return $ins;
    }

    //传入的是文章的id
    public function showComment($id)
    {
        $id = intval($id);
        $comment = DB::table('comment') -> where([['article_id', '=', $id],['uid', '=', 0]])  -> select('id', 'user_name', 'created_at', 'comment', 'article_id', 'uid') -> get() -> toArray();
        //遍历查出其子评论
        foreach ($comment as $k => $v) {
            $son_comm = DB::table('comment') -> where('uid', $comment[$k] -> id) -> get(['id', 'uid', 'article_id', 'user_name', 'comment' ,'created_at']) -> toArray();
            $comment[$k] -> childColumn = $son_comm;
        }
        return $comment;
    }
}
