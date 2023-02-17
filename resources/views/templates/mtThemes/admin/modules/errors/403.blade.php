@extends('templates.'.$themes.'.admin.index')
@section('titlepage', $titlePage)
@section('content')
<div class="main-content">
	<div class="col-md-12">
        <div class="align-center">
            <div class="error-content error_403bg">
                <div class="errors-text">403</div>
                <div class="errors-content">Không có quyền truy cập!</div>
                <div class="errors-icon"></div>
            </div>
        </div>
    </div>
    <div class="clr"></div>
</div>
@endsection()