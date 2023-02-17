@extends('templates.'.$themes.'.admin.index')
@section('titlepage', $titlePage)
@include('templates.'.$themes.'.admin.blocks.webaction')
@section('content')
<div class="main-content layout-configs">
    <form name="frmFormUpdate" id="frmFormUpdate" action="" method="POST">
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
                <input type="hidden" class="form-control input-required" name="pages" value="{{ (isset($_GET['st']) && $_GET['st'] != '') ? $_GET['st'] : '' }}" />
            </div>
            <div class="form-data-input" data-type="input" data-name="choosePage">
                <input type="hidden" class="form-control input-required" name="choosePage" value="{{ (isset($pages['id']) && $pages['id'] != '') ? $pages['id'] : '' }}" />
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
                                <div id="layout-primary" class="sortable-list layout_modules_list croll-box" data-pull="clone"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="box">
                        <div class="box-body">
                            <div class="layout-container">
                                <div class="form-group">
                                <label>Thiết lập thông tin hiển thị HEADER lên website</label>
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