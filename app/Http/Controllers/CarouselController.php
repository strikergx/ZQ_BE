<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/8/21
 * Time: 19:14
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Carousel;

class CarouselController extends Controller
{

    public function addcarousel()
    {
        $item = Carousel::max('order');
        $faLists = $lists = DB::table('lists')
            ->where('uid',0)
            ->orderBy('order','asc')
            ->get();
        $firLists = DB::table('lists')
            ->where('uid',$faLists[0]->id)
            ->get();
        $firArt = DB::table('article')
            ->where('list_id',$firLists[0]->id)
            ->get();
        return view('carousel.store',[
            'item' => $item,
            'faLists' => $faLists,
            'firLists' => $firLists,
            'firArt' => $firArt,
        ]);
    }

    public function index()
    {
        $carousel = new Carousel;
        $item = $carousel->show();
        return view('carousel.index',[
            'item' => $item['data']
        ]);
    }

    public function create()
    {
        $carousel = new Carousel;
        $item = $carousel->show();
        return view('carousel.create',[
            'item' => $item
        ]);
    }

    public function down(Request $request)
    {
        $id = $request -> get('id');
        $carousel1 = Carousel::where('id',$id)
            ->first();
        $order = $carousel1['order'];
        $res2 = Carousel::where('order',$order+1)
            ->update( [ 'order'=>$order ] );
        $res1 = Carousel::where('id',$id)
            ->update([ 'order' => $carousel1['order']+1 ]);
        if ( $res1 && $res2 ) {
            return redirect()->back()->with('sucess','上移轮播图成功');
        }else{
            return redirect()->back()->with('sucess','上移轮播图失败');
        }
    }

    public function up(Request $request)
    {
        $id = $request -> get('id');
        $carousel1 = Carousel::where('id',$id)
            ->first();
        $res2 = Carousel::where('order',$carousel1['order']-1)
            ->update( [ 'order'=>$carousel1['order'] ] );
        $res1 = Carousel::where('id',$id)
            ->update([ 'order' => $carousel1['order']-1 ]);
        if ( $res1 && $res2 ) {
            return redirect()->back()->with('sucess','下移轮播图成功');
        }else{
            return redirect()->back()->with('sucess','下移轮播图失败');
        }
    }

    public function add(Request $request){
        if ($request -> isMethod('POST')) {
            $validator = \Validator::make($request->input(), [
                'order' => "required",
                'img' => 'file',
                'art_id' => 'required',
            ], [
                'required' => ':attribute 为必填项',
                'file' => ':attribute 应为一张图片',
            ], [
                'order' => '排序',
                'img' => '轮播图',
                'art_id' => '文章id'
            ]);
            if ($validator->fails()) {
                $error = $validator -> errors();
                $err_msg['msg'] = $error -> first();
                return redirect()->back()->withErrors($validator)->withInput();
            }else{
                if ($request -> hasFile('img')){
                    $path = $request->file('img')->storeAs('carousels', uniqid().'.jpg');
                    $data['url'] = url('storage').'/'.$path;
                    $data['order'] = $request->order;
		            $data['art_id'] = $request->art_id;
                    $db = Carousel::where('order','>=',$data['order'])
                        ->get();
                    $carousel = new Carousel();
                    if (!$db->isEmpty()) {
                        for( $i = 0 ; $i<sizeof($db) ; $i++) {
                            Carousel::where('id',$db[$i]['id'])
                                ->update([ 'order' => $db[$i]['order']+1 ]);
                        }
                        //dd($db);
                        $carousel->order = $data['order'];
                        $carousel->art_id = $data['art_id'];
		                $carousel->url = $data['url'];
                        $res = $carousel -> save();
                    } else {
                        $carousel->order = $data['order'];
                        $carousel->art_id = $data['art_id'];
		                $carousel->url = $data['url'];
                        $res = $carousel -> save();
                    }
                    if($res){
                        return redirect('indexcarousel')->with('success','添加轮播图成功');
                    }else{
                        return redirect()->back()->with('error','添加失败，请重试');
                    }
                } else {
                    return redirect()->back()->with('error','请插入图片');
                }


            }
        }

//        $data = $carousel->add(intval($request->id),$request->order,$request->file('img'));
//        print_r($data);
//        if($data['code'] == 0){
//            return redirect()->back()->with('error',$data['msg']);
//        }else{
//            return redirect()->back()->with('success',$data['msg']);
//        }

    }

    public function edit(Request $request){
        $carousel = new Carousel;
        return $carousel->edit(intval($request->id),$request->order,$request->file('img'));
    }

    public function del(Request $request){
        $id = $request->get('id');
        $order = Carousel::where('id',$id)
            ->get();
        $carousel = Carousel::where('order','>',$order[0]->order)
            ->get();
        if ($carousel -> isEmpty())
        {
            $del = Carousel::where('id',$id)
                ->delete();
            if($del){
                return redirect()->back()->with('success','删除轮播图成功');
            }else{
                return redirect()->back()->with('error','删除失败，请重试');
            }
        }else{
            for($i=0;$i<sizeof($carousel);$i++)
            {
                $update = Carousel::where('id',$carousel[$i]->id)
                    ->update(['order' => $carousel[$i]->order-1] );
            }
            $del = Carousel::where('id',$id)
                ->delete();
            if($del){
                return redirect()->back()->with('success','删除轮播图成功');
            }else{
                return redirect()->back()->with('error','删除失败，请重试');
            }
        }
    }

    public function show(){
        $carousel = new Carousel;
        return $carousel->show();
    }

    public function getSon(Request $request)
    {
        $id = $request -> get('id');
        $lists = DB::table('lists')
            ->where('uid',$id)
            ->orderBy('order','asc')
            ->get();
        $articles = DB::table('article')
            ->where('list_id',$lists[0]->id)
            ->get();
        return response() -> json(['code' => 0, 'data' => $lists , 'art' => $articles]);
    }

    public function getArt(Request $request)
    {
        $id = $request->get('id');
        $art = DB::table('article')
            ->where('list_id',$id)
            ->orderBy('created_at','desc')
            ->get();
        return response() -> json(['code' => 0, 'data' => $art]);
    }


}
