@extends('templates.'.$themes.'.admin.index')
@section('titlepage', $titlePage)
@section('content')
<div class="main-content">
	<div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-body">
                    <form name="frmFormUpdate" id="frmFormUpdate" action="" method="POST">
                        <input type="text" name="txtId" value="" />
                        <input type="text" name="txtModule" value="{{ isset($module) ? $module : '' }}" />
                        <div class="autoload-modules-content"></div>
                    </form>
                </div>
            </div>
        </div>
	</div>
</div>
@endsection