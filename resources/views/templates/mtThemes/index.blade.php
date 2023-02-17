<!DOCTYPE html>
<html lang="vi">
<head>
  @php $themes = Session::has("themes") ? Session::get("themes") : "mtThemes"; @endphp
  <link rel="shortcut icon" href="{!! asset('public/images/images/iconbar.png') !!}" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta content="INDEX,FOLLOW" name="robots" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'/>
  <title>@yield('titlepage', '' )</title>
  <meta name="description" content="@yield('description', '')" />
  <meta name="keywords" content="@yield('keywords', '')" />
  <meta name="author" content="Name">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.x.x/css/swiper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.x.x/js/swiper.min.js"></script>
  <link rel="stylesheet" href="{!! url('public/templates/'.$themes.'/themes/css/main.min.css') !!}">
  @yield('webstyles', '')
  {{-- google font Roboto  --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="{!! url('public/js_css/bower_components/bootstrap/dist/css/bootstrap.min.css') !!}">
  <!-- Custom style -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <link href="{!! url('public/plugins/plugins/swipper/swiper.min.css') !!}" rel="stylesheet">
  <script src="{!! url('public/plugins/plugins/swipper/swiper.min.js') !!}"></script>
  <script src="{!! url('public/templates/'.$themes.'/js/main.min.js') !!}"></script>
  <script type="text/javascript">
    var baseURL = '<?php echo url("/"); ?>';
    var curURL = '<?php echo url()->current(); ?>';
    var app_url 	= "{!! url('/') !!}";
    var app_themes  = "mtThemes";
    var app_module  = "{{ isset($web_action['module']) ? $web_action['module'] : '' }}";
    var app_action  = "@yield('web_action', '')";
    var app_loadid  = "@yield('web_loadid', '')";
  </script>
</head>
<body>
      @include('templates.'.$themes.'.blocks.header')
      @yield('content')
      <footer>
        @include('templates.'.$themes.'.blocks.footer')
      </footer>
  </body>
</html>
