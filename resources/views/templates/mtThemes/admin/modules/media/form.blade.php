@extends('templates.'.$themes.'.admin.index')
@section('titlepage', $titlePage)
@section('content')
<div class="main-content">
    <form name="frmFormUpdate" id="frmFormUpdate" action="" method="POST">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary btnAddMedia"><i class="fa fa-picture-o" aria-hidden="true"></i> Add New Media</button>
        </div>
        <div class="clr"></div>
    </form>
</div>
@include('templates.'.$themes.'.admin.blocks.dropzone')
@endsection