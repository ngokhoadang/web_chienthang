<!DOCTYPE html>
<html lang="vi">
<head>
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
  <meta property="og:type" content="website" />
  <meta property="og:locale" content="vi_VN" />
  <meta property="og:url" content="{!! url()->current() !!}" />
  <meta property="og:image" content="@yield('images', '')" />
  <meta property="og:title" content="@yield('titlepage', '')" />
  <meta property="og:description" content="@yield('description', '')" />
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:site" content="@vattuthanhtao" />
  <meta name="twitter:creator" content="@noithatngoaithat" />
  <meta name="twitter:url" content="{!! url()->current() !!}" />
  <meta name="twitter:title" content="@yield('titlepage','')" />
  <meta name="twitter:description" content="@yield('description', '')" />
  <meta name="p:domain_verify" content="42a05d9ec36742cda59016435376ffba"/>
  <script type="text/javascript">
    var baseURL = '<?php echo url("/"); ?>';
    var curURL = '<?php echo url()->current(); ?>';
  </script>
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{!! url('public/js_css/bower_components/bootstrap/dist/css/bootstrap.min.css') !!}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{!! url('public/js_css/bower_components/font-awesome/css/font-awesome.min.css') !!}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{!! url('public/js_css/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') !!}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{!! url('public/js_css/bower_components/bootstrap-daterangepicker/daterangepicker.css') !!}">
  <!-- Custom style -->
  <link href="{!! url('public/templates/default/css/styles.css') !!}" rel="stylesheet">
  <link href="{!! url('public/templates/default/css/reponsive.min.css') !!}" rel="stylesheet">
  <!-- Swippers -->
  <link href="{!! url('public/templates/default/swipper/swiper.min.css') !!}" rel="stylesheet">
  <script src="{!! url('public/templates/default/swipper/swiper.min.js') !!}"></script>
    </head>
    <body>
      @include('templates.default.blocks.header')
      @yield('content')
      <footer>
        @include('templates.default.blocks.callbutton')
        @include('templates.default.blocks.footer')
      </footer>
      <script src="{!! url('public/js_css/dist/js/jquery-3.2.1.min.js') !!}"></script>
      <link rel="stylesheet" href="{!! url('public/js_css/bower_components/bootstrap-validate/bootstrapValidator.min.css') !!}">
      <script src="{!! url('public/js_css/bower_components/bootstrap-validate/bootstrapValidator.js') !!}"></script>
      <script src="{!! url('public/js_css/bower_components/bootstrap/dist/js/bootstrap.min.js') !!}"></script>
      <script src="{!! url('public/templates/default/js/main.min.js') !!}"></script>
      <!-- Modal Effect -->
      <script src="{{ url('public/js_css/plugins/modal-effect/velocity.min.js') }}"></script>
      <script src="{{ url('public/js_css/plugins/modal-effect/velocity.ui.min.js') }}"></script>
      <script src="{{ url('public/js_css/plugins/modal-effect/modal.effect.js') }}"></script>
      <script type="text/javascript">
        $(document).ready(function () {
            //Check to see if the window is top if not then display button
            $(window).scroll(function(){
              if ($(this).scrollTop() > 10) {
                $('.scrollToTop').fadeIn();
                //$('.header').addClass('fixed');
              } else {
                $('.scrollToTop').fadeOut();
                //$('.header').removeClass('fixed');
              }
            });
            //Click event to scroll to top
            $('.scrollToTop').click(function(){
              $('html, body').animate({scrollTop : 0},800);
              return false;
            });
            
            $('.slide-next-view').on('click', function() {
              var id = $(this).attr('data-id');
              swiper.slideTo(id, 800);
              swiper_thumb.realIndex;
            });
          });
        </script>
  </body>
</html>
