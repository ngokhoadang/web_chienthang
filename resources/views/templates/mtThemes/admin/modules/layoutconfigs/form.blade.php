@extends('templates.'.$themes.'.admin.index')
@section('titlepage', $titlePage)
@include('templates.'.$themes.'.admin.blocks.webaction')
@section('content')
<div class="main-content layout-configs">
    <form name="frmFormUpdate" id="frmFormUpdate" action="" method="POST">
        <div class="row">
            <div class="col-md-12">
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
                            <div class="form-data-input" data-type="input" data-name="pages">
                                <input type="hidden" class="form-control input-required" name="pages" value="" />
                            </div>
                            <div class="form-group">
                                <label>Chọn giao diện <small class="cl-red italic">(*)</small></label>
                                {{-- Fastselect list pages --}}
                                <input type="text" class="form-control multipleSelect" name="choosePage"  data-url="{{ url('api/layouts?st=layoutconfigs') }}" placeholder="Chọn giao diện..." />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-12">
                <div class="col-md-3 pdr-0">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" class="loadlayoutdata" data-rel="widget" data-toggle="tab" aria-expanded="true">Widget</a></li>
                            <li class=""><a href="#tab_2" class="loadlayoutdata" data-rel="columns" data-toggle="tab" aria-expanded="false">Columns</a></li>
                            <li class=""><a href="#tab_3" class="loadlayoutdata" data-rel="configs" data-toggle="tab" aria-expanded="false">Configs</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div id="layout-primary" class="sortable-list layout_modules_list scroll-box" data-pull="clone"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="box">
                        <div class="box-body">
                            <div class="layout-container">
                                <div class="form-group">
                                <label>Thêm Widget hoặc Trường dữ liệu để hiển thị lên website</label>
                                <div class="layout-data layout-body form-body"></div>
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
                    <button type="button" class="btn btn-primary btnSaveLayoutConfigAction"><i class="fa fa-floppy-o"></i> Lưu lại</button>
                </div>
            </div>
        </div>
        <div class="clr"></div>
    </form>
</div>
@include('templates.'.$themes.'.admin.blocks.modalbox')
@endsection