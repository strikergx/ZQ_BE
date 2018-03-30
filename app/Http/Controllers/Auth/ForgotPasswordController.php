<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\User;

class ForgotPasswordController extends Controller
{
    /**
     * 密码重置
     */
    public function forgotPassword(Request $request)
    {
        $User = new User();
        $email = $request -> json('email');
        $username = $request -> json('username');
        $capthca = $request -> json('captcha');
        $new_pass = $request -> json('new_password');
        if (!$user = User::where('email',$email)->first()){
            return response() -> json(['code'=>-1,'msg'=>'信息不匹配']);
        }
        $res = $User -> ResetPassword($username, $email, $new_pass, $capthca);

        if($res == -1) {
            return response() -> json(['code'=>-1,'msg'=>'信息不匹配']);
        } else if($res == -2) {
            return response() -> json(['code'=>-2,'msg'=>'验证码无效']);
        } else {
            return response() -> json(['code'=>0,'msg'=>'修改密码成功']);
        }


    }

}
