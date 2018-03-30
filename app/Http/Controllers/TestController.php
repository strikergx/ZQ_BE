<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //用来进行相关React的前端测试
    /**
     * form上传
     */
    public function TestForm(Request $request)
    {
        $data = $request -> json() -> all();
        
        return response() -> json(['data' => $data, 'msg' => 'you found me!']);
    }

    public function JsonTest(Request $request)
    {
        $username = $request -> username;
        $password = $request -> password;
        return response() -> json(['username' => $username, 'password' => $password]);
    }

    public function hashtest()
    {
        return response() -> json(['ori' => bcrypt('123456')]);
    }
}
