<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/ico" href="{{ isset($app_config['old_img_icon']) ? $app_config['old_img_icon'] : '' }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="ĐĂNG NHẬP" />
    <meta name="author" content="">
    <title>ĐĂNG NHẬP | {{ isset($app_config['app_company']) ? $app_config['app_company'] : '' }}</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ url('public/js_css/bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="{{ url('public/js_css/bower_components/metisMenu/dist/metisMenu.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ url('public/js_css/dist/css/sb-admin-2.css') }}" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="{{ url('public/js_css/bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Custom css -->
    <link href="{{ url('public/templates/default/css/re.log.min.css') }}" rel="stylesheet" type="text/css">
    <script>
        var baseURL = "{!! url('/') !!}";
    </script>
</head>

<body style="background: @if(isset($app_config['app_bg_color']) && $app_config['app_bg_color'] != "") {{ $app_config['app_bg_color'] }} @endif url(@if(isset($app_config['old_img_appbg']) && $app_config['old_img_appbg'] != "") {{ $app_config['old_img_appbg'] }} @endif) top center no-repeat;">
    <div class="container">
        <div class="row">
            <div class="padding-top"></div>
            <div class="col-md-4 col-md-offset-4">
                <div class="logo">
                    @if(isset($app_config['old_img_logo']) && $app_config['old_img_logo'] != "")
                        <img src="{{ asset($app_config['old_img_logo']) }}" />
                    @endif
                </div>
            </div>
            <div class="col-md-4 col-md-offset-4">
                <div class="form-group">
                    <div class="login_show_error"></div>
                </div>
            </div>
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-user-circle-o"></i> Đăng nhập</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="" id="loginCheck" name="loginCheck" method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Tên đăng nhập" name="txtUser" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="txtPass" type="password" value="">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" data-path="order" class="btn btn-lg btn-warning btn-block btn-md btnLogin"><i class="fa fa-shopping-cart"></i> BÁN HÀNG</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" data-path="admin" class="btn btn-lg btn-success btn-block btn-md btnLogin"><i class="fa fa-cogs"></i> QUẢN LÝ</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <!-- <div class="backlink">
                    <ul>
                        <li><a href="#">Sự cố đăng nhập</a></li>
                        <li><a href="{!! url('/') !!}">Trở về trang chủ</a></li>
                    </ul>
                </div> -->
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{!! url('public/js_css/dist/js/jquery-3.2.1.min.js') !!}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ url('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ url('bower_components/metisMenu/dist/metisMenu.min.js') }}"></script>

    <!-- Custom Theme JavaScript -->
    <script src="{{ url('dist/js/sb-admin-2.js') }}"></script>

    <!-- Boostrap Validate -->
    <link rel="stylesheet" href="{!! url('public/js_css/bower_components/bootstrap-validate/bootstrapValidator.min.css') !!}">
    <script src="{!! url('public/js_css/bower_components/bootstrap-validate/bootstrapValidator.js') !!}"></script>
    <script src="{!! url('public/js_css/bower_components/bootstrap-validate/validatorAccess.min.js') !!}"></script>

</body>

</html>
