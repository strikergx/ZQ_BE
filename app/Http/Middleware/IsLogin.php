<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use App\User;
use Closure;

class IsLogin
{

    public function handle(Request $request , Closure $next)
    {
        $token = $request -> cookie('token');
        if($user = User::where('token',$token)->first()){
            if($user->token_exp > time()){
                $user->token_exp = time() + 7200;
                return $next($request);
            }else{
                return redirect('loginpage')->with('error','登录失效，请重新登录');
            }
        }else{
            return redirect('loginpage')->with('error','请登录');
        }
    }


}