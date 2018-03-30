@extends('base')

@section('content')

    <ol class="breadcrumb" style="background-color: #f9f9f9;padding:8px 0;margin-bottom:10px;">
        <li>
            <a href=""><i class="fa fa-cogs"></i>
                链接管理</a>
        </li>
        <li class="active">
            <a href="">编辑友链</a>
        </li>
    </ol>

    @include('common.message')
    @include('common.validator')

    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="{{ url('links/index') }}">友链列表</a></li>
        <li class="active"><a href="">编辑友链</a></li>
    </ul>

    <form class="form-horizontal" id="form" action="{{ url('links/edit') }}" method="post" enctype="multipart/form-data">
        <div class="panel panel-default">
            <div class="panel-body">

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">学校</label>
                    <div class="col-sm-9">
                        <input type="text" name="school" class="form-control" value="{{ $item['school'] }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">社团名称</label>
                    <div class="col-sm-9">
                        <input type="text" name="name" class="form-control" value="{{ $item['name'] }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">社团LOGO</label>
                    <div class="col-sm-9">
                        <input type="file" name="pic"  class="form-control" placeholder="" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">社团页面</label>
                    <div class="col-sm-9">
                        <select class="js-example-basic-single form-control" name="list_id">
                            <option value="{{ $page[0]['id'] }}">{{ $page[0]['title'] }}</option>
                            @foreach($page as $pg)
                                <option value="{{ $pg['id'] }}">{{ $pg['title'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <input type="hidden" name="id" value="{{ $item['id'] }}" />
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            </div>
        </div>

        <button class="btn btn-primary" type="submit">确定</button>
    </form>

    <div class="pagination pagination-sm pull-right">
    </div>


@stop