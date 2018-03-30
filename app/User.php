<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password','portrait','power',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    private function Is_exist($email)
    {
        $user = DB::table('users') -> where('email', $email) -> first();
        if(isset($user -> password)) {
            return true;
        } else {
            return false;
        }
    }


    public function RegSendCaptcha($data)
    {
        $is_ext = $this -> Is_exist($data['email']);
        if($is_ext) {
            return -1;//用户名已经存在
        }

        $new['email'] = $data['email'];
        $new['reg_captcha'] = $data['code'];
        $new['reg_expire'] = time() + 600;
        $ins = DB::table('users') -> insertGetId($new);
        return $ins;
    }

    public function RegUpdate($data)
    {
        $email = $data['email'];
        $captcha = DB::table('users') -> where('email', $email) -> first();
        //进行验证码有效性
        if(!isset($captcha -> email)) {
            return -1;//用户不存在
        }
        if(isset($captcha -> password)) {
            return -2;//用户已经被注册
        }
        //用户记录已经存在 进行时间验证
        if($captcha -> reg_expire - time() >= 0 && $captcha -> reg_captcha == $data['captcha']) {
            $new['username'] = $data['username'];
            $new['password'] = $data['password'];
            $new['portrait'] = $data['portrait'];
            $new['created_at'] = date("Y:m:d H:i:s", time());
            $new['updated_at'] = date("Y:m:d H:i:s", time());
            $upd = DB::table('users') -> where('email', $email) -> update($new);
            return $upd;
        } else {
            return -2;//验证码已经过期
        }
    }

    public function Login($username, $password)
    {
        $user = DB::table('users') -> where('username', $username) -> first();
        //$password_hashed = bcrypt($password);
        //return ['password' => $password_hashed,'database' => $user -> password];
        if(Hash::check($password, $user -> password)) {
            //设置token
            $token = sha1(md5($username));
            $token_expire = time() + 3600;
            $upd = DB::table('users') -> where('username', $username) -> update(['token' => $token,'token_exp' => $token_expire]);

            return ['token' => $token];
        } else {
            return -1;
        }
    }

    public function ForgetPasswordUpd($email, $username, $code)
    {
        $user = DB::table('users') -> where('username', $username) -> first();
        if(!isset($user -> email) || ($user -> email != $email)) {
            return -1;//信息不匹配
        }
        $upd = DB::table('users') -> where('email', $email) -> update(['find_captcha' => $code, 'find_expire' => time() + 600]);
        return $upd;
    }

    public function ResetPassword($username, $email, $new_pass, $captcha)
    {
        $user = DB::table('users') -> where('username', $username) -> first();
        if(!isset($user -> email) || ($user -> email != $email)) {
            return -1;//信息不匹配
        }
        //如果进行判断
        if($user -> find_expire - time() >= 0 && $user -> find_captcha == $captcha) {
            $new['password'] = bcrypt($new_pass);
            //应该将当前验证码进行失效化 以免重用
            $new['find_expire'] = time();
            $upd = DB::table('users') -> where('email', $email) -> update($new);
            return $upd;
        } else {
            return -2;//验证码无效
        }
    }

    public function GetUserDetail($loginToken) 
    {
        
        $user = DB::table('users') -> where('token', $loginToken) -> first();
        if(!isset($user -> password)) {
            return false;//用户ID不存在
        }
        //增加token过期机制
        if($user -> token_exp - time() <= 0) {
            return false;//失去登录
        }
        return $user;
    }
}
