<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    //重写了评论相关
    public function addComment(Request $request)
    {
        //$reqdata = $request -> json()
        $content = $request -> json('content');
        $article = $request -> json('article');
        $username = $request -> json('username');
        $comment = $request -> json('comment');

        $Comment = new Comment();

        $res = $Comment -> addComment($content, $article, $username, $comment); //返回插入的id
        if($res > 0) {
            return response() -> json(['code' => 0, 'id' => $res]);
        } else {
            return response() -> json(['code' => -1, 'msg' => 'insert failed']);
        }
    }

    public function showComment($id)
    {
        //出示相关评论，并且使用UId的方式进行出示
        //先显示出相关评论，然后将其子评论遍历出来进行显示
        $Comment = new Comment();
        $res = $Comment -> showComment($id);
        return response() -> json(['code' => 0, 'data' => $res]);
    }
}