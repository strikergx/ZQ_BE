@extends('base')

@section('content')

    @include('common.message')

    <ol class="breadcrumb" style="background-color: #f9f9f9;padding:8px 0;margin-bottom:10px;">
        <li>
            <a href=""><i class="fa fa-cogs"></i>
                友链管理</a>
        </li>
        <li class="active">
            <a href="">友链列表</a>
        </li>
    </ol>

    @include('common.message')
    @include('common.validator')

    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="">友链列表</a></li>
        <li ><a href="{{ url('links/addpage') }}">添加友链</a></li>
    </ul>

    <form action="" method="post">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th width="80">编号</th>
                        <th width="">学校</th>
                        <th width="">社团名称</th>
                        <th>社团LOGO</th>
                        <th width="200">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($item as $vo)
                        <tr>
                            <td>{{ $vo->id }}</td>
                            <td>{{ $vo->school }}</td>
                            <td>{{ $vo->name }}</td>
                            <td><img src="{{ $vo->pic }}" class="img-responsive" /></td>
                            <td>
                                <div class="btn-group">
                                    <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle">操作 <span class="caret"></span></button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="{{ url('/links/editpage?id='.$vo->id) }}">编辑</a></li>
                                        <li class="divider"></li>
                                        <li><a href="{{ url('/links/del?id='.$vo->id) }}">删除</a></li>
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
        {{ $item->links() }}
    </div>

@stop