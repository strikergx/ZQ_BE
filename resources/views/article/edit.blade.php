@extends('base')

@section('content')

<ol class="breadcrumb" style="background-color: #f9f9f9;padding:8px 0;margin-bottom:10px;">
    <li>
        <a href=""><i class="fa fa-cogs"></i>
            文章管理</a>
    </li>
    <li class="active">
        <a href="">文章编辑</a>
    </li>
</ol>

@include('common.message')
@include('common.validator')

<ul class="nav nav-tabs" role="tablist">
    <li><a href="{{ url('indexart') }}">文章管理</a></li>
    <li class="active"><a href="">文章编辑</a></li>
</ul>
<form class="form-horizontal" id="form"  action="{{ url('editart') }}" method="post">

    {{ csrf_field() }}

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">文章管理</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">文章标题</label>
                <div class="col-sm-9">
                    <textarea type="text" name="title"  class="form-control" placeholder="文章标题">{{ $article[0]->title }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">责任编辑</label>
                <div class="col-sm-9">
                    <textarea type="text" name="author"  class="form-control" placeholder="责任编辑">{{ $article[0] -> author }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">文章来源</label>
                <div class="col-sm-9">
                    <textarea type="text" name="source"  class="form-control" placeholder="文章来源">{{ $article[0] -> source }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">所属栏目</label>
                <div class="col-sm-9">
                    <select class="js-example-basic-single form-control" name="list_id">
                        <option value="{{ $article[0]->list_id }}">{{ $list[$article[0]->list_id]->name }}</option>
                        @foreach($list as $vo)
                            <option value="{{ $vo->id }}">{{ $vo->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for=""  class="col-sm-2 control-label">文章内容</label>
                <div id="ueditor" class="col-sm-9">
                    <textarea id="container" name="content" style="height:300px;width:100%;">{{ $article[0] -> content }}</textarea>
                    @include('UEditor::head')
                </div>
                <script id="container" name="content" type="text/plain">
                请输入文本
                </script>
                <script type="text/javascript">
                    var ue = UE.getEditor('container');
                    ue.ready(function () {
                        ue.execCommand('serverparam','_token','{{ csrf_token() }}');
                    });
                </script>
            </div>
            <input type="hidden" value="{{ $article[0]->id }}" name="id">
        </div>
    </div>
    <button class="btn btn-primary" type="submit">确定</button>
</form>
@stop