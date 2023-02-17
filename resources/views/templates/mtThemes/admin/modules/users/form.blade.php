@extends('templates.'.$themes.'.admin.index')
@section('titlepage', $titlePage)
@include('templates.'.$themes.'.admin.blocks.webaction')
@section('content')
<div class="main-content">
    <div class="row">
        <div class="col-md-12">
            <form name="frmFormUpdate" id="frmFormUpdate" action="" method="POST">
                <input class="form-control" type="hidden" name="txtUserId" value="{{ isset($data['data']['id']) ? $data['data']['id'] : '' }}" />
                <div class="col-md-5">
                    <div class="box account">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Chọn quyền quản trị <small class="cl-red italic">(*)</small></label>
                                <div>
                                    <input type="text" class="form-control multipleSelect" name="txtUserGroup" value="{{ isset($data['group_selected']) ? $data['group_selected'] : '' }}" data-initial-value="{{ isset($data['group_initial']) ? $data['group_initial'] : '' }}" data-url="{{ url('/api/groups') }}" placeholder="Chọn quyền quản trị" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Tên đăng nhập <small class="cl-red italic">(*)</small></label>
                                <input class="form-control input-required" type="text" name="txtUserName" value="{{ isset($data['data']['name']) ? $data['data']['name'] : '' }}" placeholder="Nhập tên đăng nhập" />
                            </div>
                            <div class="form-group">
                                <label>Mật khẩu <small class="cl-red italic">(*)</small></label>
                                <input class="form-control checkpasswordequal" type="password" name="txtPassword" id="txtPassword" />
                            </div>
                            <div class="form-group">
                                <label>Nhập lại mật khẩu</label>
                                <input class="form-control checkpasswordequal" type="password" name="retxtPassword" id="retxtPassword" />
                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Họ và tên <small class="cl-red italic">(*)</small></label>
                                <input class="form-control input-required" type="text" name="txtFullName" value="{{ isset($data['data']['fullname']) ? $data['data']['fullname'] : '' }}" placeholder="Nhập họ và tên" />
                            </div>
                            <div class="form-group">
                                <label>Địa chỉ Email</label>
                                <input class="form-control" type="email" name="txtEmail" id="txtEmail" value="{{ isset($data['data']['email']) ? $data['data']['email'] : '' }}" placeholder="Nhập địa chỉ email" />
                            </div>
                            <div class="form-group">
                                <label>Điện thoại</label>
                                <input class="form-control" type="text" name="txtPhone" value="{{ isset($data['data']['phone']) ? $data['data']['phone'] : '' }}" placeholder="Nhập số điện thoại" />
                            </div>
                            <div class="form-group">
                                <label>Giới tính</label>
                                <select name="txtUserSex" class="form-control">
                                    <option value="Nam" {{ (isset($data['data']['sex']) && $data['data']['sex'] == 'Nam') ? 'selected' : '' }}>Nam</option>
                                    <option value="Nữ"  {{ (isset($data['data']['sex']) && $data['data']['sex'] == 'Nữ') ? 'selected' : '' }}>Nữ</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Trạng thái</label>
                                <div class="form-group">
                                    <label class="radio-inline">
                                        <input name="rdoStatus" value="1" {{ (isset($data['data']['status']) && $data['data']['status'] == 1) ? 'checked' : '' }} type="radio"> Kích hoạt
                                    </label>
                                    <label class="radio-inline">
                                        <input name="rdoStatus" value="0" {{ (isset($data['data']['status']) && $data['data']['status'] == 0) ? 'checked' : '' }} type="radio"> Tạm ẩn
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="box">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label>Ảnh đại diện (KT: 100 x 100px)</label>
                                        <input class="form-control" type="file" name="images" id="images" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box">
                                <div class="box-body align-center">
                                    <input type="hidden" name="oldImage" value="{{ isset($data['data']['avatar']) ? asset($data['data']['avatar']) : '' }}" />
                                    <img src="{{ isset($data['data']['avatar']) ? asset($data['data']['avatar']) : '' }}" style="max-width: 100%; max-height: 70px;" />
                                </div>
                            </div>
                        </div>
                    </div>
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
                            <button type="button" class="btn btn-primary btn-sm btnuserupdateaction"><i class="fa fa-floppy-o"></i> Lưu lại</button>
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