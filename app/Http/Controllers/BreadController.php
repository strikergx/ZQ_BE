<?php
/**
 * Created by PhpStorm.
 * User: GTX
 * Date: 2017/9/18
 * Time: 16:37
 */

namespace App\Http\Controllers;

use App\Bread;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BreadController extends Controller
{
    public function FetchBread(Request $request)
    {
        $Bread = new Bread();
        $artid = $request -> input('id');

        $data = $Bread -> FetchBread($artid);
        return response() -> json(['code' => 0, 'data' => $data]);
    }

    public function Bread2($cid) 
    {
        $Bread = new Bread();        
        
        $res = $Bread -> Bread2($cid);
        return response() -> json(['code' => 0, 'data' => $res]);
    }

    public function FetFather($cid) {
        $Bread = new Bread();
        $res = $Bread -> BreadFather($cid);
        return response() -> json(['code' => 0, 'data' => $res]);
    }
}