@extends('templates.'.$themes.'.admin.index')
@section('titlepage', $titlePage)
@section('content')
<div class="main-content">
	<div class="col-md-12">
        <div class="align-center">
            <div class="error-content error_404bg">
                <div class="errors-text">404</div>
                <div class="errors-content">Trang không tồn tại!</div>
                <div class="errors-icon"></div>
            </div>
        </div>
        <div class="error-details">
        @if(isset($message) && !empty($message))
            <div class="error-header">Chi tiết:</div>
            <ul>
                @foreach ($message as $items)
                    <li>{{ $items }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
    <div class="clr"></div>
</div>
@endsection()