@extends('base')

@section('content')
<ol class="breadcrumb" style="background-color: #f9f9f9;padding:8px 0;margin-bottom:10px;">
    <li>
        <a href=""><i class="fa fa-cogs"></i>
            栏目管理</a>
    </li>
    <li class="active">
        <a href="">栏目添加</a>
    </li>

</ol>

@include('common.message')
@include('common.validator')

<ul class="nav nav-tabs" role="tablist">
    <li><a href={{ url('indexlists') }}>栏目列表</a></li>
    <li class="active"><a href="">编辑栏目</a></li>
</ul>
<form class="form-horizontal" id="form" action="{{ url('editlists') }}" method="get">
            {{ csrf_field() }}
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">栏目管理</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">栏目名称</label>
                <div class="col-sm-9">
                    <input type="text" name="name"  class="form-control" placeholder="" value="{{ $item['name'] }}">
                </div>
            </div>

            <div class="form-group">
                <label for="" class="col-sm-2 control-label">栏目排序</label>
                <div class="col-sm-9">
                    <select class="js-example-basic-single form-control" name="order">
                        <option value="{{ $item['order'] }}">{{ $item['order'] }}</option>
                        @for($i = 1 ; $i <= $item['maxorder'] ; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-9">
                    <input type="hidden" name="id"  class="form-control" placeholder="" value="{{ $item['id'] }}">
                </div>
            </div>

        </div>
    </div>
    <button class="btn btn-primary" type="submit">确定</button>
</form>

@stop

