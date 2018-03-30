@extends('base')

@section('content')

    @include('common.message')

    <ol class="breadcrumb" style="background-color: #f9f9f9;padding:8px 0;margin-bottom:10px;">
        <li>
            <a href=""><i class="fa fa-cogs"></i>
                轮播图管理</a>
        </li>
        <li class="active">
            <a href="">轮播图列表</a>
        </li>
    </ol>

    @include('common.message')
    @include('common.validator')

    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="">轮播图列表</a></li>
        <li><a href="{{ url('addcarousel') }}">添加轮播图</a></li>
    </ul>

    <form action="" method="post">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th width="80">排序</th>
                        <th>轮播图</th>
                        <th width="200">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($item as $vo)
                        <tr>
                            <td>{{ $vo['order'] }}</td>
                            <td><img src="{{ $vo['url'] }}" class="img-responsive" /></td>
                            <td>
                                <div class="btn-group">
                                    <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle">操作 <span class="caret"></span></button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        @if($vo['id']!=1)<li><a href="{{ url('up?id='.$vo['id']) }}">上移</a></li>@endif
                                        @if($vo['id']!=sizeof($item))<li><a href="{{ url('down?id='.$vo['id']) }}">下移</a></li>@endif
                                        <li class="divider"></li>
                                        <li><a href="{{ url('/carousel/del?id='.$vo['id']) }}">删除</a></li>
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
    </div>
    <script>
        function del(id) {
            util.confirm('确定删除吗?',function(){
                //alert('点击确定后执行的回调函数');
                location.href = "{{  url('dellists') }}"+'?id='+id;
            })
        }
    </script>

@stop