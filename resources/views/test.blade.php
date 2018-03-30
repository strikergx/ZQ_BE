
 <div id="ueditor" class="edui-default">
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