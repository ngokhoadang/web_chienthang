@extends('templates.'.$themes.'.admin.index')
@section('titlepage', $titlePage)
@include('templates.'.$themes.'.admin.blocks.webaction')
@section('content')
<div class="main-content layout-configs">
    <form name="frmFormUpdate" id="frmFormUpdate" action="" method="POST">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="row" style="padding: 100px 0">
                            <div class="col-md-3"></div>
                            <div class="col-md-2"><a href="{{ url('/admin/layoutconfigs/setting?st=header') }}" class="btn btn-primary"><i class="fa fa-cogs" aria-hidden="true"></i> Thiết lập HEADER</a></div>
                            <div class="col-md-2"><a href="{{ url('/admin/layoutconfigs/create') }}" class="btn btn-warning"><i class="fa fa-cogs" aria-hidden="true"></i> Thiết lập BODY</a></div>
                            <div class="col-md-2"><a href="{{ url('/admin/layoutconfigs/setting?st=footer') }}" class="btn btn-success"><i class="fa fa-cogs" aria-hidden="true"></i> Thiết lập FOOTER</a></div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clr"></div>
    </form>
</div>
@endsection