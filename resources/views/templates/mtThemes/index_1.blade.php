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
  <link rel="stylesheet" href="{!! url('public/templates/'.$themes.'/themes/css/main.min.css') !!}">
  @yield('webstyles', '')
  {{-- google font Roboto  --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
  <!-- Custom style -->
  <link href="{!! url('public/plugins/plugins/swipper/swiper.min.css') !!}" rel="stylesheet">
  <script src="{!! url('public/plugins/plugins/swipper/swiper.min.js') !!}"></script>
  <script type="text/javascript">
    var baseURL = '<?php echo url("/"); ?>';
    var curURL = '<?php echo url()->current(); ?>';
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
