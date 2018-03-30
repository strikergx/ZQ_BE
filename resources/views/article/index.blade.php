@extends('base')

@section('content')

<ol class="breadcrumb" style="background-color: #f9f9f9;padding:8px 0;margin-bottom:10px;">
    <li>
        <a href=""><i class="fa fa-cogs"></i>
            文章管理</a>
    </li>
    <li class="active">
        <a href="">文章列表</a>
    </li>
</ol>

@include('common.message')
@include('common.validator')

<ul class="nav nav-tabs" role="tablist">
    <li class="active"><a href="#tab1">文章管理</a></li>
    <li><a href="{{ url('storeart') }}">文章添加</a></li>
</ul>
<form action="" method="post">
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th width="5%">编号</th>
                    <th>文章名称</th>
                    <th>文章作者</th>
                    <th>所属分类</th>
                    <th>添加时间</th>
                    <th width="200">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach( $article as $vo )
                <tr>
                    <td>{{ $vo->id }}</td>
                    @if(mb_strlen($vo->title) > 10)
                        <td>{{ mb_substr($vo->title,0,10,'utf-8').'......' }}</td>
                    @else
                        <td>{{ $vo->title }}</td>
                    @endif
                    <td>{{ $vo->author }}</td>
                    <td>{{$vo->name}}</td>
                    <td>{{ date('Y-m-d H:m',$vo->created_at) }}</td>
                    <td>
                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle">操作 <span class="caret"></span></button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ url('editit?id='.$vo->id) }}">编辑</a></li>
                                <li class="divider"></li>
                                <li><a href="{{ url('delart?id='.$vo->id) }}">删除到回收站</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</form>
<div class="pagination pagination-sm pull-right">
    {{ $article->links() }}
</div>
@stop