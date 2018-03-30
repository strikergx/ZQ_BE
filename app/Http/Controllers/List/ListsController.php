<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Lists;


class ListController extends Controller
{

    public function editPage(Request $request)
    {
        $item['id'] = $request -> get('id');
        $db = Lists::where('id' , $item['id'])
            ->first();
        $order = Lists::where('uid',$db['uid'])
            ->max('order');
        $item['maxorder'] = $order;
        $item['order'] = $db['order'];
        $item['name'] = $db['name'];
        return view('category.edit',[
            'item' => $item,
        ]);

    }

    public function index()
    {
        $lists = new Lists();
        $msg = $lists -> show();
        return view('category.index',[
            'item' => $msg['res']
        ]);

    }

    public function create()
    {
//        $list = Lists::where('uid',0)
//            -> orderBy('order')
//            -> get();
//
//        for ($i=0 ; $i < sizeof($list) ; $i++)
//        {
//            $item[$i]['column'] = $list[$i]['name'];
//            $item[$i]['id'] = $list[$i]['id'];
//            $num = Lists::where( 'uid' , $list[$i]['id'] )
//                ->count();
//            $item[$i]['num'] = $num;
//        }
//
//        return view('category.store',[
//            'item' => $item
//        ]);

        $lists = new Lists();
        $msg = $lists -> show();
        return view('category.store',[
            'item' => $msg['res']
        ]);
    }

    public function showLists(Request $request)
    {
        if ($request -> isMethod('GET'))
        {
            $lists = new Lists();
            $msg = $lists -> show();
            return $msg;
        }

    }

    public function addLists(Request $request)
    {
        if ($request -> isMethod('POST')) {
            $validator = \Validator::make($request->input(), [
                'column' => 'required',
                'order' => 'required|integer',
                'uid' => 'required|integer',
            ], [
                'required' => ':attribute 为必填项',
                'integer' => ':attribute 必须为整数',
            ], [
                'column' => '栏目名',
                'order' => '栏目位置',
                'uid' => '父级栏目'
            ]);
            if ($validator -> fails()){
                return redirect()->back()->withErrors($validator)->withInput();
//                $err_msg['code'] = 1;
//                $error = $validator -> errors();
//                $err_msg['msg'] = $error ->first();
//                return $err_msg;
            }
            $data = $request ->all();
            $lists = new Lists();
            $msg = $lists -> add($data);
            if ($msg['code'] == 0) {
                return redirect('indexlists');
            } else {
                return redirect()->back()->with('error',$msg['msg']);
            }
        }

    }

    public function editLists(Request $request)
    {
        if ($request -> isMethod('GET')) {
            $validator = \Validator::make($request->input(), [
                'name' => 'required',
                'id' => 'required|integer',
                'order' => 'required|integer'
            ], [
                'required' => ':attribute 为必填项',
                'integer' => ':attribute 必须为整数'
            ], [
                'name' => '栏目名',
                'id' => '栏目id',
                'order' => '排序'
            ]);
            if ($validator -> fails()){
                return redirect()->back()->withErrors($validator)->withInput();
//                $err_msg['code'] = 1;
//                $error = $validator -> errors();
//                $err_msg['msg'] = $error ->first();
//                return $err_msg;
            }
            $data = $request ->all();
            $lists = new Lists();
            $msg = $lists -> edit($data);
            if ($msg['code'] == 0) {
                return redirect('indexlists')->with('success',$msg['msg']);
            } else {
                return redirect()->back()->with('error',$msg['msg']);
            }
            return $msg;
        }


    }

    public function delLists(Request $request)
    {
        if ($request -> isMethod('GET')) {
            $validator = \Validator::make($request->input(), [
                'id' => 'required|integer',
            ], [
                'required' => ':attribute 为必填项',
                'integer' => ':attribute 必须为整数',
            ], [
                'id' => '栏目'
            ]);
            if ($validator -> fails()){
                $err_msg['code'] = 1;
                $error = $validator -> errors();
                $err_msg['msg'] = $error ->first();
                return $err_msg;
            }
            $data = $request ->all();
            $lists = new Lists();
            $msg = $lists -> del($data);
            if ($msg['code'] == 0) {
                return redirect()->back()->with('success',$msg['msg']);
            } else {
                return redirect()->back()->with('error',$msg['msg']);
            }

        }

    }


}
