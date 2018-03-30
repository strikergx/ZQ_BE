<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FrontUser extends Model
{
    public function Reg($username, $password, $email)
    {
        if($this -> UserIsExist($username)) {
            return -1;//用户名已经存在
        }


        $salt = rand(1000, 9999);
        $password = sha1(md5($password, $salt));
        $data['username'] = $username;
        $data['password'] = $password;
        $data['email'] = $email;
        $data['salt'] = $salt;
        $data['created_at'] = date("Y:m:d H:i:s", time());
        $data['updated_at'] = date("Y:m:d H:i:s", time());
        $ins = DB::table('fontuser')
            -> insertGetId($data);
        return $ins;
    }

    public function Login($username, $password)
    {
        $user_inf = DB::table('fontuser') -> where('username', $username) -> first();
        if(!isset($user_inf -> password)) {
            return -1;//用户不存在
        } else {
            $hashed_password = sha1(md5($password, $user_inf -> salt));
            if($hashed_password == $user_inf -> password) {
                return 1;
            } else {
                return -2;//用户密码错误
            }

        }
    }

    private function UserIsExist($username) {
        $rec = DB::table('fontuser') -> where('username', $username) -> first();
        if(isset($rec -> password)) {
            return true;
        } else {
            return false;
        }
    }
}
