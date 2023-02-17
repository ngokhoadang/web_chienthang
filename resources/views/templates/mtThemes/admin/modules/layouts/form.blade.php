@extends('templates.'.$themes.'.admin.index')
@section('titlepage', $titlePage)
@include('templates.'.$themes.'.admin.blocks.webaction')
@section('content')
<div class="main-content">
    <form name="frmFormUpdate" id="frmFormUpdate" action="" method="POST">
        <div class="col-md-6">
            <div class="box">
                <div class="box-body form-data">
                    <div class="form-data-get" data-type="input" data-name="id" data-key="id">
                        <input type="hidden" class="form-control" name="id" value="" />
                    </div>
                    <div class="form-data-input" data-type="input" data-name="themes">
                        <input type="hidden" class="form-control input-required" name="themes" value="{{ $themes }}" />
                    </div>
                    <div class="form-data-input" data-type="input" data-name="status">
                        <input type="hidden" class="form-control input-required" name="status" value="1" />
                    </div>
                    <div class="form-group">
                        <label>Tên giao diện <small class="cl-red italic">(*)</small></label>
                        <div class="form-data-input" data-type="input" data-name="name">
                            <input type="text" class="form-control input-required" id="layoutName" name="name" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Chọn trang <small class="cl-red italic">(*)</small></label>
                        {{-- Fastselect list pages --}}
                        <div class="form-data-input" data-type="select" data-name="pages" data-key="pages">
                            <div class="fastselectbox">
                                <input type="text" class="form-control multipleSelect" id="layoutSelectPages" name="pages" value=""  data-url="{{ url('admin/pages/json') }}" placeholder="Chọn trang..." />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="layout-container">
                        <div class="form-group">
                            <label>Header</label>
                            <div class="form-group layout-header form-header"></div>
                            <button type="button" class="btn btn-success btn-sm addLineLayout" data-key="header"><i class="fa fa-plus" aria-hidden="true"></i> Thêm dòng</button>
                        </div>
                        <div class="form-group">
                            <label>Body</label>
                            <div class="form-group layout-body form-body"></div>
                            <button type="button" class="btn btn-success btn-sm addLineLayout" data-key="body"><i class="fa fa-plus" aria-hidden="true"></i> Thêm dòng</button>
                        </div>
                        <div class="form-group">
                            <label>Footer</label>
                            <div class="form-group layout-footer form-footer"></div>
                            <button type="button" class="btn btn-success btn-sm addLineLayout" data-key="footer"><i class="fa fa-plus" aria-hidden="true"></i> Thêm dòng</button>
                        </div>
                        <div class="clr"></div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <button type="button" class="btn btn-primary btnSaveLayoutAction"><i class="fa fa-floppy-o"></i> Lưu lại</button>
                </div>
            </div>
        </div>
        <div class="clr"></div>
    </form>
</div>
@include('templates.'.$themes.'.admin.blocks.modalbox')
@endsection