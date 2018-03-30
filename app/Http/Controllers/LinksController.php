<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Links;


class LinksController extends Controller
{
    public function index()
    {
        $link = new Links();
        $item = $link->page();
        return view('links.index',[
            'item' => $item,
        ]);
    }

    public function addPage()
    {
        $links = new Links();
        $item = $links -> getPage();
        return view('links.add',[
            'page' => $item,
        ]);
    }

    public function editPage(Request $request)
    {
        $id = $request -> get('id');
        $links = new Links();
        $item = $links -> getLinks($id);
        return view('links.edit',[
            'item' => $item['data'],
            'page' => $item['page'],
        ]);

    }

    public function showLinks(Request $request)
    {
        $link = new Links();
        return json_encode($link->show());
    }

    public function editLinks(Request $request)
    {
        $data = $request ->all();
        $validator = \Validator::make($data, [
            'id' => 'required',
            'name' => 'required',
            'url' => 'required',
            'pic' => 'image',
            'school' => 'required',
        ], [
            'required' => ':attribute 为必填项',
            'image' => ':attribute 应该为图片'
        ], [
            'name' => '名字',
            'url' => '地址',
            'pic' => '图片',
            'school' => '学校名称',
        ]);
        if ($validator -> fails()) {
            $error = $validator -> errors();
            $err_msg['msg'] = $error -> first();
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $path = $request->file('pic')->storeAs('links', uniqid() . '.jpg');
            $data['pic'] = url('storage') . '/app/' . $path;
            $data['name'] = $request->name;
            $data['id'] = $request->id;
            $data['url'] = $request->url;
            $data['school'] = $request->school;
            $link = new Links();
            $res = $link->edit($data);
            if($res){
                return redirect('links/index')->with('sucess','编辑友链成功');
            }else{
                return redirect()->back()->with('error','编辑失败，请重试');
            }
        }

    }


    public function addLinks(Request $request)
    {
        $data = $request ->all();
        $validator = \Validator::make($data, [
            'name' => 'required',
            'url' => 'required',
            'pic' => 'image',
            'school' => 'required',
        ], [
            'required' => ':attribute 为必填项',
            'image' => ':attribute 应该为图片'
        ], [
            'name' => '名字',
            'url' => '地址',
            'pic' => '图片',
            'school' => '学校名称',
        ]);
        if ($validator -> fails()) {
            $error = $validator -> errors();
            $err_msg['msg'] = $error -> first();
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $path = $request->file('pic')->storeAs('links', uniqid() . '.jpg');
            $data['pic'] = url('storage') . '/app/' . $path;
            $data['name'] = $request->name;
            $data['url'] = $request->url;
            $data['school'] = $request->school;
            $link = new Links();
            $res = $link->add($data);
            if($res){
                return redirect('links/index')->with('sucess','添加友链成功');
            }else{
                return redirect()->back()->with('error','添加失败，请重试');
            }
        }

    }

    public function delLinks(Request $request)
    {
        $id = $request -> get('id');
        $link = new Links();
        $res = $link -> del($id);
        if($res){
            return redirect('links/index')->with('sucess','删除友链成功');
        }else{
            return redirect()->back()->with('error','删除失败，请重试');
        }
    }


}
