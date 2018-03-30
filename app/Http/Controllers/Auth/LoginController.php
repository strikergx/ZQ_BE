<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        $User = new User();
        $username = $request -> json('username');
        $password = $request -> json('password');
        //弃用Cookie 使用token
        $res = $User -> Login($username, $password);
        //return response() -> json(['data' => $res]);
        if(isset($res['token'])) {
            //$cookie = cookie('loginToken', $username, 60);
            return response() -> json(['code' => 0, 'token'=> $res['token']]);
        } else {
            //$cookie = cookie('loginToken','ignore_me', -1);
            return response() -> json(['code' => -1, 'msg'=>'login fail']);
        }
    }

    public function loginout()
    {
        setcookie('token','');
        return view('login/index');
    }

    public function loginAdmin(Request $request)
    {
        if ($request -> isMethod('POST')) {
            $validator = \Validator::make($request->input(), [
                'email' => 'required',
                'password' => 'required',
            ], [
                'required' => ':attribute 为必填项',
            ], [
                'email' => '邮箱',
                'password' => '密码',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                if($user = User::where('email',$request->email)->first()){
                    $password = $request->password;
                    if (Hash::check($password, $user->password)){
                        $request->session()->put('username',$user->username);
                        $this->setToken($request->email);
                        return redirect('index');
                    }else{
                        return redirect()->back()->with('error','密码错误');
                    }
                }else{
                    return redirect()->back()->with('error','用户名或密码错误');
                }
            }
        }


    }

    public function logout()
    {
        $cookie = cookie('loginToken', 'ignore_me', -1);
        return response() -> json(['code' => 0, 'msg' => 'logout ok']) -> withCookie($cookie);
    }

    /**
    * 生成用户信息，确定用户是否登录
    */
    public function UserDetail(Request $request) 
    {
        $User = new User();
        //必须使用cookie才可以应该使用cookie进行检索
        $loginToken = $request-> json('token');
        if($loginToken == null) {
            return response() -> json(['code' => -2, 'msg' => '尚未登陆']);
        }
        
        $res = $User -> GetUserDetail($loginToken);
        if(!$res) {
            return response() -> json(['code' => -1, 'msg' => '用户不存在']);
        } else {
            return response() -> json(['code' => 0, 'data' => $res]);
        }
    }


    public function setToken($email){
        $user = User::where('email',$email)->first();
        $token = sha1(md5($user->username . time()));
        $user->token = $token;
        Cookie::queue('token',$token);
        $user->token_exp = time()+7200;
        if($user->save()){
            return '';
        }else{
            return json_encode(['code'=>3,'msg'=>'登录失败']);
        }
    }


}
