<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Order;
use App\Mail\OrderShipped;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
//    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('guest');
//    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required',
            'email' => 'required|email',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *  进行注册 包括验证验证码
     * @param  array  $data
     * @return \App\User
     */
    protected function register(Request $request)
    {
        $User = new User();
        //$validator = $this->validator($request->json());
        //$errors = $validator->errors()->first();
        if (true){
            //$path = $portrait->storeAs('portraits', uniqid().'.jpg');
            $path = "111";
            if (true) {
                $data = [
                    'username' => $request->json('username'),
                    'email' => $request->json('email'),
                    'password' => bcrypt($request->json('password')),
                    'captcha' => $request -> json('captcha'),
                    'portrait' => 'http://www.thmaoqiu.cn/poetry/storage/app/'.$path,
                    'power' => 0,
                ];
                $res = $User -> RegUpdate($data);
                if ($res == -2) {
                    return response() -> json(['code' => -2, 'msg' => '用户名已经被注册']);
                } else if($res == -1) {
                    return response() -> json(['code' => -1, 'msg' => '记录不存在']);
                } else if($res == 1) {
                    return response() -> json(['code' => 0, 'msg' => '注册成功']);
                } else {
                    return response() -> json(['code' => -3, 'msg' => '注册失败请重试']);
                }
            } else {
                return response() -> json(['code' => -1, 'msg' => $errors]);
            }
        }else{
            return response() -> json(['code'=>3,'msg'=>'请插入用户头像']);
        }

    }

    protected function adminRegister(Request $request){
        $validator = $this->validator($request->all());
        $errors = $validator->errors()->first();
        if($portrait = $request->file('portrait')){
            $path = $portrait->storeAs('portraits', uniqid().'.jpg');
            if (empty($errors)) {
                $data = [
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'portrait' => 'http://www.thmaoqiu.cn/poetry/storage/app/'.$path,
                    'power' => 1,
                ];
                if (User::create($data)) {
                    return json_encode(['code' => 0, 'msg' => '管理员注册成功']);
                } else {
                    return json_encode(['code' => 2, 'msg' => '注册失败请稍后再试']);
                }
            } else {
                return bcrypt($request->password);
            }
        }else{
            return json_encode(['code'=>3,'msg'=>'请插入用户头像']);
        }
    }



}
