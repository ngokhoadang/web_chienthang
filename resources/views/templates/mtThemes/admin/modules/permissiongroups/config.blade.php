@extends('templates.'.$themes.'.admin.index')
@section('titlepage', $titlePage)
@include('templates.'.$themes.'.admin.blocks.webaction')
@section('content')
<div class="main-content layout-configs">
    <form name="frmFormUpdate" id="frmFormUpdate" action="" method="POST">
        <div class="row form-group">
            <div class="col-md-12">
                <div class="col-md-3 pdr-0">
                    <div id="sortable-primary" class="sortable-list group-permission" data-pull="true"></div>
                </div>
                <div class="col-md-9">
                    <div class="box">
                        <div class="box-header with-border">
                            <h5 class="bold">Sắp xếp quyền hạn theo nhóm</h5>
                        </div>
                        <div class="box-body">
                            <div class="layout-container form-data">
                                <div class="form-group">
                                    <div class="permissiongroups-data layout-body form-body"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <button type="button" class="btn btn-primary btnSavePermissionGroup"><i class="fa fa-floppy-o"></i> Lưu lại</button>
                </div>
            </div>
        </div>
        <div class="clr"></div>
    </form>
</div>
@include('templates.'.$themes.'.admin.blocks.modalbox')
@endsection