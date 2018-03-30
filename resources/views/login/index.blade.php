<!DOCTYPE html>
<html lang="en" class="bg-dark">
<head>
    <meta charset="utf-8"/>
    <title>中青后台登陆</title>
    <meta name="description"content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <link href="{{ asset('/static/admin/bootstrap-3.3.0-dist/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/static/admin/admin.ui/css/animate.css') }}" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('/static/admin/admin.ui/css/app.css') }}" type="text/css"/>
    <!--[if lt IE 9]>
    <script src="{{ asset('/static/admin/admin.ui/js/ie/html5shiv.js') }}"></script>
    <script src="{{ asset('/static/admin/admin.ui/js/ie/respond.min.js') }}"></script>
    <script src="{{ asset('/static/admin/admin.ui/js/ie/excanvas.js') }}"></script>
    <![endif]-->
</head>
<body class="">
<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
    <div class="container aside-xxl">
        <a class="navbar-brand block" href="">中青后台管理</a>
        <section class="panel panel-default bg-white m-t-lg">
            <header class="panel-heading text-center">
                <strong>管理员后台登陆</strong>
            </header>

            @include('common.message')
            @include('common.validator')

            <form method="post" action="{{ url('loginadmin') }}" class="panel-body wrapper-lg">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="control-label">邮箱</label>
                    <input  type="text" class="form-control input-lg" name="email">
                </div>
                <div class="form-group">
                    <label class="control-label">密 码</label>
                    <input  type="password"  class="form-control input-lg" name="password">
                </div>

                <button type="submit" class="btn btn-primary">登陆后台</button>
            </form>
        </section>
    </div>
</section>
<!-- footer -->
<footer id="footer">
    <div class="text-center padder">
        <p>
            <small>Powered By fushengshe.com<br> copyright &copy; 2017</small>
        </p>
    </div>
</footer>
<script src="{{ asset('/static/admin/admin.ui/js/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('/static/admin/admin.ui/js/bootstrap.js') }}"></script>
<!-- App -->
<script src="{{ asset('/static/admin/admin.ui/js/app.js') }}"></script>
<script src="{{ asset('/static/admin/admin.ui/js/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('/static/admin/admin.ui/js/app.plugin.js') }}"></script>
</body>
</html>