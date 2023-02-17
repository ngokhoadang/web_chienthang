@extends('templates.'.$themes.'.admin.index')
@section('titlepage', $titlePage)
@include('templates.'.$themes.'.admin.blocks.webaction')
@section('content')
<div class="main-content">
    <form name="frmFormUpdate" id="frmFormUpdate" action="" method="POST">
        <div class="form-data">
            <div class="col-md-6">
                <div class="loading-proccess">
                    <div class="loading-bar"></div>
                </div>
                <div class="box">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Chọn loại MODULE <small class="no-strong italic cl-red p_sm">(* Bắt buộc)</small></label>
                            <div class="fastselectbox">
                                <input type="text" class="form-control multipleSelect input-required" name="moduleType" value="" data-initial-value="" data-url="{{ url('/api/pages') }}" placeholder="Chọn trang hiển thị" />
                            </div>
                        </div>
                        <div class=" form-group">
                            <label for="txtName">Tên Module <small class="no-strong italic cl-red p_sm">(* Bắt buộc)</small></label>
                            <input type="text" class="form-control" name="moduleName" id="moduleName" value="">
                        </div>
                        <div class=" form-group form-input">
                            <label for="txtPageLength">Số lượng mẫu tin / trang</label>
                            <input type="text" class="form-control input-required" name="moduleLength" id="moduleLength" value="">
                        </div>
                        <div class=" form-group form-group">
                            <div class="form-group">
                                <label for="txtOrder">Sắp xếp</label>
                                <div class="group-box radio-group group-box-group">
                                    <div class="row">
                                        <div class="cols-group col-md-4">
                                            <div class=" form-group form-input">
                                                <input type="text" class="form-control " name="moduleOrder" id="moduleOrder" value="0">
                                            </div>
                                        </div>
                                        <div class=" form-group form-radio">
                                            <div class="radio-box">
                                                <input type="radio" checked name="moduleSort" id="txtSort" value="asc">
                                                <label for="txtSort">Tăng dần  </label>
                                            </div>
                                        </div>
                                        <div class=" form-group form-radio">
                                            <div class="radio-box">
                                                <input type="radio" name="moduleSort" id="txtSort1" value="desc">
                                                <label for="txtSort1">Giảm dần</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="loading-proccess">
                    <div class="loading-bar"></div>
                </div>
                <div class="box">
                    <div class="box-header with-border bold">CẤU HÌNH MÔ DUN HIỂN THỊ</div>
                    <div class="box-body">
                        <div class="modules-list"><div class="warning">Vui lòng chọn module</div></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <ul class="modules-detail todo-list"></ul>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <button type="button" class="btn btn-primary btn-sm btnmoduleconfigsaveaction"><i class="fa fa-floppy-o"></i> Lưu lại</button>
                    </div>
                </div>
            </div>
            <div class="clr"></div>
        </div>
    </form>
</div>
@include('templates.'.$themes.'.admin.blocks.modalbox')
@endsection