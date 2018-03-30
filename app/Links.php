<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Links extends Model
{
    public function page()
    {
        $links = DB::table('links')
            ->paginate(5);
        return $links;
    }

    public function show()
    {
        $links = DB::table('links')
            ->get();
        if ($links) {
            $rand_array = range(1, sizeof($links));
            shuffle($rand_array);
            $len = array_slice($rand_array, 0, 4);
            $res = array();
            for ($i=0; $i<4; $i++)
            {
                $j = $len[$i]-1;
                $res['data'][$i]['id'] = $links[$j]->id;
                $res['data'][$i]['url'] = $links[$j]->url;
                $res['data'][$i]['pic'] = $links[$j]->pic;
                $res['data'][$i]['name'] = $links[$j]->name;
                $res['data'][$i]['school'] = $links[$j]->school;
                $res['code'] = 0;
            }
            return $res;
        } else {
            return ['code'=>1,'msg'=>'查询轮播图失败，请稍后再试'];
        }

    }

    public function getLinks($id)
    {
        $link = DB::table('links')
            ->where('id', $id)
            ->get();
        $res['data']['id'] = $link[0]->id;
        $res['data']['url'] = $link[0]->url;
        $res['data']['pic'] = $link[0]->pic;
        $res['data']['name'] = $link[0]->name;
        $res['data']['school'] = $link[0]->school;

        $res['page'] = self::getPage();
        return $res;

    }

    public function getPage()
    {
        $articles = DB::table('article')
            ->where('list_id', 22)
            ->get();
        $res = array();
        for ($i=0; $i<sizeof($articles); $i++)
        {
            $res[$i]['title'] = $articles[$i] -> title;
            $res[$i]['id'] = $articles[$i] -> id;
        }
        return $res;
    }

    public function edit($data)
    {
        $link['id'] = $data['id'];
        $link['name'] = $data['name'];
        $link['pic'] = $data['pic'];
        $link['url'] = $data['url'];
        $link['school'] = $data['school'];
        $db = DB::table('links')
            ->where('id', $data['id'])
            ->update($link);
        return $db;
    }

    public function del($id)
    {
        $db = DB::table('links')
            ->where('id', $id)
            ->delete();
        return $db;
    }

    public function add($data)
    {
        $link['name'] = $data['name'];
        $link['pic'] = $data['pic'];
        $link['url'] = $data['url'];
        $link['school'] = $data['school'];
        $db = DB::table('links')
            ->insert($link);
        return $db;
    }


}