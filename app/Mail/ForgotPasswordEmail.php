<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/8/27
 * Time: 12:08
 */

namespace App\Mail;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordEmail extends Mailable
{

    public function email(Request $request)
    {
        $User = new User();
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code = $code . rand(0, 9);
        }
        $data = ['email' => $request->json('email'), 'code' => $code];

        Mail::send('emails', $data, function ($message) use ($data) {
            $message->to($data['email'])->subject('您正在重置密码，请查收验证码！');
        });
        //重置密码生成验证码要写入数据库以便进行验证
        $res = $User -> ForgetPasswordUpd($request -> json('email'), $request -> json('username'), $data['code']);
        if($res == -1) {
            return response() -> json(['code' => -1, 'msg' => '信息不匹配']);
        } else {
            return response() -> json(['code' => 0, 'msg' => $code]);
        }

    }
}