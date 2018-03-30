<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Article;


class ArticleController extends Controller
{

    public function indexbin()
    {
        $article = DB::table('article')
            ->where('is_del',1)
            ->orderBy('created_at','desc')
            ->paginate(5);;
        for ($i=0;$i<sizeof($article);$i++)
        {
            $list = DB::table('lists')
                ->where('id',$article[$i] -> list_id)
                ->get();
            $article[$i]->name = $list[0]->name;
        }
        return view('article.recycle',[
            'article' => $article,
        ]);

    }

    public function index(Request $request)
    {
        $article = DB::table('article')
            ->where('is_del',0)
            ->orderBy('created_at','desc')
            ->paginate(5);
        for ($i=0;$i<sizeof($article);$i++)
        {
            $list = DB::table('lists')
                ->where('id',$article[$i] -> list_id)
                ->get();
            $article[$i]->name = $list[0]->name;
        }
        return view('article.index',[
            'article' => $article,

        ]);

    }



    public function store()
    {
        $list = DB::table('lists')
            ->where('uid','>',0)
            ->get();
        return view('article.store',[
            'list' => $list,
        ]);
    }

    public function addArt(Request $request)
    {
        if ($request -> isMethod('POST')) {
            $validator = \Validator::make($request->input(), [
                'title' => 'required',
                'author' => 'required',
                'content' => 'required',
                'source' => 'required',
                'list_id' => 'required',
            ], [
                'required' => ':attribute 为必填项',
            ], [
                'title' => '文章标题',
                'author' => '责任编辑',
                'content' => '文章内容',
                'source' => '文章来源',
                'list_id' => '所属栏目',
            ]);
            if ($validator -> fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $data = $request ->all();
            $add = new Article();
            $msg = $add -> add($data);
            if ($msg['code'] == 0) {
                return redirect('indexart')->with('success',$msg['msg']);
            } else {
                return redirect()->back()->with('error',$msg['msg']);
            }
            return $msg;
        }
    }

    public function delforever(Request $request)
    {
        if($request -> isMethod('GET')) {
            $validator = \Validator::make($request->input(), [
                'id' => 'required',
            ], [
                'required' => ':attribute 为必填项',
            ], [
                'id' => '要删除的文章'
            ]);
            if ($validator -> fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $data = $request ->all();
            $add = new Article();
            $msg = $add -> dele($data);
            if ($msg['code'] == 0){
                return redirect()->back()->with('success',$msg['msg']);
            } else {
                return redirect()->back()->with('error',$msg['msg']);
            }
        }
    }

    public function delArt(Request $request)
    {
        if($request -> isMethod('GET')) {
            $validator = \Validator::make($request->input(), [
                'id' => 'required',
            ], [
                'required' => ':attribute 为必填项',
            ], [
                'id' => '要删除的文章'
            ]);
            if ($validator -> fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $data = $request ->all();
            $add = new Article();
            $msg = $add -> del($data);
            if ($msg['code'] == 0){
                return redirect()->back()->with('success',$msg['msg']);
            } else {
                return redirect()->back()->with('error',$msg['msg']);
            }
        }
    }


    public function showArt(Request $request)
    {
        if($request -> isMethod('GET')) {
            $validator = \Validator::make($request->input(), [
                'id' => 'required',
            ], [
                'required' => ':attribute 为必填项',
            ], [
                'id' => '文章id'
            ]);
            if ($validator -> fails()){
                $err_msg['code'] = 1;
                $error = $validator -> errors();
                $err_msg['msg'] = $error ->first();
                return $err_msg;
            }
            $data = $request ->all();
            $add = new Article();
            $msg = $add -> show($data);
            return $msg;
        }
    }

    public function editArt(Request $request)
    {
        if ($request -> isMethod('POST')) {
            $validator = \Validator::make($request->input(), [
                'title' => 'required',
                'author' => 'required',
                'content' => 'required',
                'source' => 'required',
                'list_id' => 'required',
                'id' => 'required',
            ], [
                'required' => ':attribute 为必填项',
            ], [
                'title' => '标题',
                'author' => '责任编辑',
                'content' => '文章内容',
                'source' => '文章来源',
                'list_id' => '所属栏目',
                'id' => '文章id',
            ]);
            if ($validator -> fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $data = $request ->all();
            $add = new Article();
            $msg = $add -> edit($data);
            if ($msg['code'] == 0){
                return redirect('indexart')->with('success',$msg['msg']);
            } else {
                return redirect('indexart')->with('error',$msg['msg']);
            }
            return $msg;
        }
    }

    public function editIt(Request $request)
    {
        $id =$request -> get('id');
        $article = DB::table('article')
            ->where('id',$id)
            ->get();
        $list = DB::table('lists')
            ->where('uid','>',0)
            ->get();
        return view('article.edit',[
            'list' => $list,
            'article' => $article,
        ]);
    }

    public function showTitle(Request $request)
    {
        //增加查出当前分类的相关信息
        if($request -> isMethod('GET')) {
            $validator = \Validator::make($request->input(), [
                'list_id' => 'required',
            ], [
                'required' => ':attribute 为必填项',
            ], [
                'list_id' => '栏目'
            ]);
            if ($validator -> fails()){
                $err_msg['code'] = 1;
                $error = $validator -> errors();
                $err_msg['msg'] = $error ->first();
                return $err_msg;
            }
            $data = $request ->all();
            $add = new Article();
            $msg = $add -> showHeader($data);
            return $msg;
        }
    }

    public function showMore(Request $request)
    {
        if($request -> isMethod('GET')) {
            $validator = \Validator::make($request->input(), [
                'list_id' => 'required',
            ], [
                'required' => ':attribute 为必填项',
            ], [
                'list_id' => '栏目'
            ]);
            if ($validator -> fails()){
                $err_msg['code'] = 1;
                $error = $validator -> errors();
                $err_msg['msg'] = $error ->first();
                return $err_msg;
            }
            $data = $request ->all();
            $add = new Article();
            $msg = $add -> More($data);
            return $msg;
        }
    }

    public function SiteMovition()
    {
        $Article = new Article();
        $data['data'] = $Article -> SiteMov();
        if(count($data['data']) > 0) {
            $data['first_content'] = mb_substr($data['data'][0]['content'], 0, 18, 'utf-8');
        } else {
            $data['first_content'] = "暂无消息";
        }

        return response() -> json(['code' => 0, 'data'=>$data]);
    }

    public function NewsExpress()
    {
        $Article = new Article();
        $data['data'] = $Article -> NewExpress();
        if(count($data['data']) > 0) {
            $data['first_content'] = mb_substr($data['data'][0]['content'], 0, 18, 'utf-8');
        } else {
            $data['first_content'] = "暂无消息";
        }
        return response() -> json(['code' => 0, 'data' => $data]);
    }

    /**
     * 按照分类查询文章
     */
    public function CateArticle($id)
    {
        $Article = new Article();
        $data = $Article -> CateArticle($id);
        return response() -> json(['code' => 0, 'data' => $data]);
    }


}

