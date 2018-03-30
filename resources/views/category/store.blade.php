@extends('base')

@section('content')

<ol class="breadcrumb" style="background-color: #f9f9f9;padding:8px 0;margin-bottom:10px;">
    <li>
        <a href=""><i class="fa fa-cogs"></i>
            栏目管理</a>
    </li>
    <li class="active">
        <a href="">添加栏目</a>
    </li>

</ol>

@include('common.message')
@include('common.validator')

<ul class="nav nav-tabs" role="tablist">
    <li><a href="{{ url('indexlists') }}">栏目列表</a></li>
    <li class="active"><a href="">添加栏目</a></li>
</ul>
<form class="form-horizontal" id="form" action="{{ url('addlists') }}" method="post">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">栏目管理</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">栏目名称</label>
                <div class="col-sm-9">
                    <input type="text" name="column"  class="form-control" placeholder="" value="">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">所属栏目</label>
                <div class="col-sm-9">
                    <select class="js-example-basic-single form-control" name="uid">
                        <option value="0">顶级栏目</option>
                        @foreach  ( $item as $vo )
                            <option value="{{ $vo['id'] }}">{{ $vo['column'] }}</option>
                        {{--<option {if condition="$oldData['cate_pid']==$vo['cate_id']"}selected{/if} value="{$vo['cate_id']}">{$vo['_cate_name']}</option>--}}
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="" class="col-sm-2 control-label">栏目排序</label>
                <div class="col-sm-9">
                    <input type="number" name="order"  class="form-control" placeholder="" value="">
                </div>
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

        </div>
    </div>
    {{--<input type="hidden" name="cate_id" value="{:input('param.cate_id')}">--}}
    <button class="btn btn-primary" type="submit">确定</button>
</form>

@stop

