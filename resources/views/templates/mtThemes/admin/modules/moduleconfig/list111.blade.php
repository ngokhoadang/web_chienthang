@extends('templates.'.$themes.'.admin.index')
@section('titlepage', $titlePage)
@section('content')
<div class="main-content">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <table id="table-girdview-ajax" class="table table-bordered table-hover">
                    @include('templates.'.$themes.'.admin.blocks.datatable')
                </table>
            </div>
        </div>
    </div>
</div>
@endsection