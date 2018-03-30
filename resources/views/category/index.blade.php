@extends('base')

@section('content')

<ol class="breadcrumb" style="background-color: #f9f9f9;padding:8px 0;margin-bottom:10px;">
    <li>
        <a href=""><i class="fa fa-cogs"></i>
            栏目管理</a>
    </li>
    <li class="active">
        <a href="">栏目列表</a>
    </li>
</ol>

    @include('common.message')
    @include('common.validator')

<ul class="nav nav-tabs" role="tablist">
    <li class="active"><a href="">栏目列表</a></li>
    <li><a href="{{ url('createlists') }}">添加栏目</a></li>
</ul>
<form action="" method="post">
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th width="80">排序</th>
                    <th>栏目名称</th>
                    <th width="200">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($item as $vo)
                <tr>
                    <td>{{ $vo['order'] }}</td>
                    <td>{{ $vo['column'] }}</td>
                    <td>
                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle">操作 <span class="caret"></span></button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                {{--<li><a href="{:url('addSon',['cate_id'=>$vo['cate_id']])}">添加子类</a></li>--}}
                                <li><a href="javascript:;" onclick="edit({{$vo['id']}})">编辑</a></li>
                                <li class="divider"></li>
                                <li><a href="javascript:;" onclick="del({{$vo['id']}})">删除</a></li>
                            </ul>
                        </div>
                    </td>

                </tr>
                    @if ( array_key_exists('childColumn',$vo) )
                        @foreach ( $vo['childColumn'] as $cc )
                            <tr>
                                <td>{{ $vo['order'].'-'.$cc['order'] }}</td>
                                <td>{{ '|--'.$cc['name'] }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle">操作 <span class="caret"></span></button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            {{--<li><a href="{:url('addSon',['cate_id'=>$vo['cate_id']])}">添加子类</a></li>--}}
                                            <li><a href="javascript:;" onclick="edit({{$cc['id']}})">编辑</a></li>
                                            <li class="divider"></li>
                                            <li><a href="javascript:;" onclick="del({{$cc['id']}})">删除</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</form>
<div class="pagination pagination-sm pull-right">
</div>
<script>
    function edit(id) {
        location.href = "{{ url('editpage') }}" + '?id=' + id;
    }
    function del(id) {
        util.confirm('确定删除吗?',function(){
            //alert('点击确定后执行的回调函数');
            location.href = "{{  url('dellists') }}"+'?id='+id;
        })
    }
</script>

@stop