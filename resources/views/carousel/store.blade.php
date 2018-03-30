@extends('base')

@section('content')

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
        <li ><a href="{{ url('indexcarousel') }}">轮播图列表</a></li>
        <li class="active"><a href="">添加轮播图</a></li>
    </ul>

    <form class="form-horizontal" id="form" action="{{ url('carousel/add') }}" method="post" enctype="multipart/form-data">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">轮播图排序</label>
                    <div class="col-sm-9">
                        <select class="js-example-basic-single form-control" name="order">
                            @for($i = 1 ; $i<$item+2 ; $i++)
                                <option name="order" value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">轮播图</label>
                    <div class="col-sm-9">
                        <input type="file" name="img"  class="form-control" placeholder="" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">父栏目</label>
                    <div class="col-sm-9">
                        <select class="js-example-basic-single form-control" name="" id="first">
                            @foreach($faLists as $vo)
                                <option name="" value="{{ $vo->id }}">{{ $vo->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">子栏目</label>
                    <div class="col-sm-9">
                        <select class="js-example-basic-single form-control" name="" id="second">
                            @foreach($firLists as $vo)
                                <option name="" value="{{ $vo->id }}">{{ $vo->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">文章</label>
                    <div class="col-sm-9">
                        <select class="js-example-basic-single form-control" name="art_id" id="third">
                            @foreach($firArt as $vo)
                                <option value="{{ $vo->id }}">{{ $vo->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            </div>
        </div>
        {{--<input type="hidden" name="cate_id" value="{:input('param.cate_id')}">--}}
        <button class="btn btn-primary" type="submit">确定</button>
    </form>

    <div class="pagination pagination-sm pull-right">
    </div>
    <script>
        $(document).ready(function () {
            $("#first").change(function () {
                var id = $("#first").find("option:selected").val();
                console.log(id);
                $.ajax({
                    "type" : "GET",
                    "url" : "{{ url('/getSon?id=') }}"+id,
                    "data" : {} ,
                    success:function (data) {
                        $("#second").empty();
                        console.log(data['data']);
                        for(var i=0;i<data['data'].length;i++)
                        {
                            console.log('ha');
                            var value = data['data'][i].id;
                            var text = data['data'][i].name;
                            $("#second").append("<option value="+value+">"+text+"</option>");
                        }
                        $("#third").empty();
                        for(var i=0;i<data['art'].length;i++)
                        {
                            var value = data['art'][i].id;
                            var text = data['art'][i].title;
                            $("#third").append("<option name='art_id' value="+value+">"+text+"</option>");
                        }
                    }
                });

            });

            $("#second").change(function () {
                var id = $("#second").find("option:selected").val();
                console.log(id);
                $.ajax({
                    "type" : "GET",
                    "url" : "{{ url('/getArt?id=') }}"+id,
                    "data" : {},
                    success:function (data) {
                        $("#third").empty();
                        console.log(data['data']);
                        for(var i=0;i<data['data'].length;i++)
                        {
                            console.log('ha');
                            var value = data['data'][i].id;
                            var text = data['data'][i].title;
                            $("#third").append("<option name='art_id' value="+value+">"+text+"</option>");
                        }
                    }
                });
            });

        });
        function del(id) {
            util.confirm('确定删除吗?',function(){
                //alert('点击确定后执行的回调函数');
                location.href = "{{  url('dellists') }}"+'?id='+id;
            })
        }



    </script>

@stop