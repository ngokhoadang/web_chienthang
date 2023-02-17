@extends('templates.'.$themes.'.admin.index')
@section('titlepage', $titlePage)
@include('templates.'.$themes.'.admin.blocks.webaction')
@section('content')
<div class="main-content">
    <div class="row">
        <div class="col-md-12">
            <form name="frmFormUpdate" id="frmFormUpdate" action="" method="POST">
                <input class="form-control" type="hidden" name="txtGroupId" value="{{ isset($data['data']['id']) ? $data['data']['id'] : '' }}" />
                <div class="col-md-5">
                    <div class="box account">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Tên nhóm <small class="cl-red italic">(*)</small></label>
                                <input class="form-control input-required" type="text" name="txtGroupName" value="{{ isset($data['data']['name']) ? $data['data']['name'] : '' }}" placeholder="Nhập nhóm" />
                            </div>
                            <div class="form-group">
                                <label>Mô tả nhóm</label>
                                <textarea class="form-control" name="txtGroupIntro" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="box">
                        <div class="box-body">
                            <div class="box-header with-border">
                                <h3 class="box-title">Phân quyền</h3>
                            </div>
                            <div class="autoload-permission">
                                <div class="croll-box"><div class="warning">Không tìm thấy quyền hạn thành viên</div></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-body">
                            <button type="button" class="btn btn-primary btn-sm btngroupudateaction"><i class="fa fa-floppy-o"></i> Lưu lại</button>
                        </div>
                    </div>
                </div>
                <div class="clr"></div>
            </form>
        </div>
    </div>
</div>
@include('templates.'.$themes.'.admin.blocks.modalbox')
@endsection