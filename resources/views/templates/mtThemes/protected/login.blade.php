<!DOCTYPE html>
<html lang="en">
<head>
    @php $themes = Session::has("themes") ? Session::get("themes") : "mtThemes"; @endphp
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/ico" href="{{ isset($app_config['old_img_icon']) ? $app_config['old_img_icon'] : '' }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="ĐĂNG NHẬP" />
    <meta name="author" content="">
    <title>ĐĂNG NHẬP | {{ isset($app_config['app_company']) ? $app_config['app_company'] : '' }}</title>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ url('public/plugins/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('public/plugins/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ url('public/templates/'.$themes.'/protected/login.min.css') }}">
    <script>
        var app_url = "{!! url('/') !!}";
    </script>
</head>

<body style="background: #ccc @if(isset($app_config['app_bg_color']) && $app_config['app_bg_color'] != "") {{ $app_config['app_bg_color'] }} @endif url(@if(isset($app_config['old_img_appbg']) && $app_config['old_img_appbg'] != "") {{ $app_config['old_img_appbg'] }} @endif) top center no-repeat;">
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
                                    <input class="form-control input-required" placeholder="Tên đăng nhập" name="txtUser" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="txtPass" type="password" value="">
                                </div>
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-success form-control btnLogin"><i class="fa fa-sign-in" aria-hidden="true"></i> Đăng nhập</button>
                                    </div>
                                    <div class="col-md-3"></div>
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
    <script src="{{ url('public/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ url('templates/'.$themes.'/protected/check.main.js') }}"></script>

</body>

</html>
