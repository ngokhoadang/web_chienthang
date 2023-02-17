@extends('templates.'.$themes.'.admin.index')
@section('titlepage', $titlePage)
@include('templates.'.$themes.'.admin.blocks.webaction')
@section('content')
<div class="main-content">
    <form name="frmFormUpdate" id="frmFormUpdate" action="" method="POST">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-8">
                    <div class="box">
                        <div class="box-body">
                            @include('templates.'.$themes.'.admin.blocks.formget_default')
                            <div class="autoload-modules-contents autoload-modules-contents-left"></div>
                        
                            <span class="modal-button-action"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box">
                        <div class="box-body">
                            <div class="autoload-modules-contents autoload-modules-contents-right"></div>
                            @include('templates.'.$themes.'.admin.blocks.buttondefault')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="clr"></div>
</div>
@include('templates.'.$themes.'.admin.blocks.modalbox')
@include('templates.'.$themes.'.admin.blocks.dropzone')
@endsection