@extends('templates.'.$themes.'.admin.index')
@section('titlepage', $titlePage)
@section('content')
<div class="main-content">
    <form name="frmFormUpdate" id="frmFormUpdate" action="" method="POST">
        <div class="col-md-10">
            <div class="box">
                <div class="box-body form-data">
                    @include('templates.'.$themes.'.admin.blocks.formget_default')
                    <div class="form-data-get" data-type="input" data-name="txtType" data-key="type">
                        <input type="hidden" name="txtType" value="create" />
                    </div>
                    <div class="form-data-get" data-type="input" data-name="txtModule" data-key="modules">
                        <input type="hidden" name="txtModule" value="{{ isset($module) ? $module : '' }}" />
                    </div>
                    @include('templates.'.$themes.'.admin.blocks.form_setup')
                </div>
            </div>
            <div class="box">
                <div class="box-body form-detail">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 5%" class="align-center">#</th>
                                <th style="width: 25%">Label</th>
                                <th style="width: 25">Field name</th>
                                <th style="width: 25%">File Type</th>
                                <th style="width: 10%" class="align-center"><i class="fa fa-sort-numeric-asc" aria-hidden="true"></i></th>
                                <th style="width: 10%" class="align-center"><i class="fa fa-check-square-o" aria-hidden="true"></i></th>
                            </tr>
                        </thead>
                        <tbody class="autoload-modules-contents"></tbody>
                    </table>
                    <div class="form-group">
                        <div class="form-group"></div>
                        <button type="button" class="btn btn-success btn-sm right btnaddfields"><i class="fa fa-plus"></i> Thêm mới</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="box">
                <div class="box-body">
                    <div class="align-center">
                        <button type="button" class="btn btn-primary form-control btnSaveFeildAction"><i class="fa fa-floppy-o"></i> Lưu lại</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="clr"></div>
    </form>
</div>
@include('templates.'.$themes.'.admin.blocks.modalbox')
@endsection