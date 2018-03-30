<?php

namespace App\Http\Controllers;

use App\FrontUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function Reg(Request $request)
    {
        $FU = new FrontUser();
        $username = $request -> json('username');
        $password = $request -> json('password');
        $email = $request -> json('email');

        $res = $FU -> Reg($username, $password, $email);

        if($res > 0) {
            return response() -> json(['code' => 0, 'msg' => 'reg ok']);
        } else if($res == -1){
            return response() -> json(['code' => -1, 'msg' => '用户名已经存在']);
        } else {
            return response() -> json(['code' => -2, 'msg' => '注册失败']);
        }
    }

    public function Login(Request $request)
    {
        $FU = new FrontUser();
        $username = $request -> json('username');
        $password = $request -> json('password');

        $res = $FU -> Login($username, $password);
        //return response() -> json(['data' => $res]);
        if($res == -1) {
            return response() -> json(['code' => -1, 'msg' => '用户不存在']);
        } else if($res == -2) {
            return response() -> json(['code' => -2, 'msg' => '用户名或者密码错误']);
        } else {
            $cookie = cookie('loginToken', $username, 60);
            return response() -> json(['code' => 0, 'msg' => 'login ok']) -> withCookie($cookie);
        }
    }

    public function Logout()
    {
        return response() -> json(['code'=>0, 'msg'=>'logout ok'])->withCookie(cookie('loginToken', '', -1));
    }

    public function Ht()
    {
        return response() -> json(['data' => sha1(md5('guoguo','8026'))]);
    }

}
