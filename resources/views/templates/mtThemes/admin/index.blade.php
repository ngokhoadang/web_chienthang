<!DOCTYPE html>
<html lang="en">
<head>
    @php $themes = Session::has("themes") ? Session::get("themes") : "mtThemes"; @endphp
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>@yield('titlepage', 'ADMIN CONTROL')</title>
    <link rel="shortcut icon" type="image/ico" href="@yield('app.favicon', '')"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ url('public/plugins/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('public/plugins/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{!! url('public/templates/'.$themes.'/admin/plugins/iCheck/all.css') !!}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('public/plugins/dist/css/AdminLTE.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ url('public/plugins/dist/css/skins/_all-skins.min.css') }}">
    <!-- My style -->
    <link rel="stylesheet" href="{{ url('public/templates/'.$themes.'/admin/css/admin.style.min.css') }}">
    <link rel="stylesheet" href="{{ url('public/templates/'.$themes.'/admin/plugins/media/media.main.css') }}">
    <!-- Uploads and Crop image -->
    <link rel="stylesheet" href="{{ url('public/templates/'.$themes.'/admin/plugins/cropper/cropper.min.css') }}">
    <link rel="stylesheet" href="{{ url('public/templates/'.$themes.'/admin/plugins/dropzone/basic.css') }}">
    <link rel="stylesheet" href="{{ url('public/templates/'.$themes.'/admin/plugins/dropzone/dropzone.css') }}">
    <link rel="stylesheet" href="{{ url('public/templates/'.$themes.'/admin/plugins/dropzone/dropzonecrop.min.css') }}">
    <!-- datetime-picker -->
    <link rel="stylesheet" href="{{ url('public/plugins/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- Fast Select jsquery -->
    <link rel="stylesheet" href="{!! url('public/templates/'.$themes.'/admin/plugins/fastselect/fastselect.min.css') !!}">
    <!-- jQuery 3 -->
    <script src="{{ url('public/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <link rel="stylesheet" href="{!! url('public/templates/'.$themes.'/admin/css/datatable.custom.min.css') !!}">
    <script src="{!! url('public/plugins/bower_components/datatables.net/js/jquery.dataTables.min.js') !!}"></script>
    <script src="{{ asset('/public/templates/'.$themes.'/admin/plugins/cropper/cropper.min.js') }}"></script>
    <script>
        var app_url 	= "{!! url('/') !!}";
        var app_page    = "admin";
        var app_themes  = "mtThemes";
        var app_module  = "@yield('web_module', '')";
        var app_action  = "@yield('web_action', '')";
        var app_loadid  = "@yield('web_loadid', '')";
        var widthPage	= Math.max(window.screen.width, window.innerWidth);
    </script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    @include('templates.'.$themes.'.admin.blocks.header')
    @include('templates.'.$themes.'.admin.blocks.menu')
    <div class="content-wrapper">
        @include('templates.'.$themes.'.admin.blocks.breadcrumb')
        @yield('content')
    </div>
    @include('templates.'.$themes.'.admin.blocks.footer')
</div>
<!-- jQuery UI 1.11.4 -->
<script src="{{ url('public/plugins/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ url('public/plugins/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- MODAL EFFECT -->
<script src="{!! url('public/plugins/plugins/modal-effect/velocity.min.js') !!}"></script>
<script src="{!! url('public/plugins/plugins/modal-effect/velocity.ui.min.js') !!}"></script>
<script src="{!! url('public/plugins/plugins/modal-effect/modal.effect.js') !!}"></script>
<!-- AdminLTE App -->
<script src="{{ url('public/plugins/dist/js/adminlte.min.js') }}"></script>
<!-- MAIN App -->
<script src="{{ url('public/templates/'.$themes.'/admin/js/admin.main.min.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ url('public/plugins/dist/js/pages/dashboard.js') }}"></script>
<!-- Fast Select jsquery -->
<script src="{!! url('public/templates/'.$themes.'/admin/plugins/fastselect/fastselect.standalone.js') !!}"></script>
<!-- iCheck 1.0.1 -->
<script src="{!! url('public/templates/'.$themes.'/admin/plugins/iCheck/icheck.min.js') !!}"></script>
{{-- CKEDITOR --}}
<script language="javascript" src="{!! url('public/templates/'.$themes.'/admin/plugins/editor/ckeditor/ckeditor.js') !!}"></script>
{{-- <script src="{{ asset('/public/templates/'.$themes.'/admin/plugins/editor/ckfinder/ckfinder.js') }}"></script>
<script src="{{ asset('/public/templates/'.$themes.'/admin/plugins/editor/ckfinder/configckf.js') }}"></script> --}}

<script src="{{ asset('/public/templates/'.$themes.'/admin/plugins/dropzone/dropzone.js') }}"></script>
<script src="{{ asset('/public/templates/'.$themes.'/admin/plugins/dropzone/dropzonecropconfigs.min.js') }}"></script>
<script src="{{ asset('/public/templates/'.$themes.'/admin/plugins/sortable/sortable.js') }}"></script>
<script src="{{ asset('/public/templates/'.$themes.'/admin/plugins/sortable/config.js') }}"></script>
<!-- datetime-picker -->
<script src="{{ asset('public/plugins/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
<script>
    $(function(){

        $('.multipleSelect').fastselect();

        // CKEDITOR.replace('editor2');
        $('.editor').each(function() {

            var editorID    = $(this).attr('id');

            CKEDITOR.replace(editorID);

        });
        
    });
</script>
</body>
</html>
