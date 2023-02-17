@php
    $menu   = Session::has('menu') ? Session::get('menu') : [];
    // Session::forget('menu');
@endphp
<div class="main-menu">
    @if(isset($menu))
        {!! $menu !!}
    @endif
</div>
