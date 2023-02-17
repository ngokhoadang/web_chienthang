@extends('templates.'.$themes.'.admin.index')
@section('titlepage', $titlePage)
@include('templates.'.$themes.'.admin.blocks.webaction')
@section('content')
<div class="main-content">
    <form name="frmFormUpdate" id="frmFormUpdate" action="" method="POST">
        <input type="hidden" name="widget_id" value="{{ isset($data['data']['default']['id']) ? $data['data']['default']['id'] : '' }}">
        <input type="hidden" name="widget_modules" value="{{ isset($data['data']['default']['module']) ? $data['data']['default']['module'] : '' }}">
        <div class="col-md-12">
            <ul class="nav nav-tabs pull-left widgetTabs">
                <li class="active">
                    <a href="#sales-chart" data-toggle="tab" data-type="widget">Widget quảng cáo</a>
                </li>
                <li class="">
                    <a href="#revenue-content" data-toggle="tab" data-type="contents">Widget bài viết</a>
                </li>
                <li class="">
                    <a href="#revenue-product" data-toggle="tab" data-type="products">Widget sản phẩm</a>
                </li>
                <li class="">
                    <a href="#revenue-default" data-toggle="tab" data-type="default">Widget mặc định</a>
                </li>
            </ul>
        </div>
        <!-- WIDGET DEFAULT -->
        <div class="col-md-6">
            <div class="box box-info box-body">
                <div class="form-group">
                    <label>Tiêu đề <small class="cl-red italic">(*)</small></label>
                    <input type="text" class="form-control input-required" name="txtWidgetName" value="{{ isset($data['data']['widget_title']) ? $data['data']['widget_title'] : '' }}" placeholder="Nhập tiêu đề widget" />
                </div>
                <div class="form-group widget-items widget_show">
                    <label>Nội dung widget</label>
                    <textarea class="form-control editor" name="txtWidgetContent" id="editor"></textarea>
                </div>
                <div class="form-group widget-items default_show">
                    <label>Tên thư mục Widget</label>
                    <input type="text" class="form-control" name="txtWidgetFolder" value="{{ isset($data['data']['default']['content']) ? $data['data']['default']['content'] : '' }}" placeholder="File Content" />
                </div>
                <div class="form-group widget-items contents_show products_show">
                    <label>Chủ đề</label>
                    <div class="fastselectbox">
                        <input type="text" class="form-control  multipleSelect" name="sltWidgetType" value="" data-initial-value="" data-url="{{ url('api/categories') }}" placeholder="Chọn danh mục....">
                    </div>
                </div>
                <div class="form-group widget-items contents_show products_show">
                    <label>Trạng thái hiển thị</label>
                    <select class="form-control" name="sltWidgetSate">
                        <option value="new" {{ isset($data['data']['products']['state']) && $data['data']['products']['state'] == 'new' ? 'checked' : '' }}>Nội dung mới cập nhật (NEW)</option>
                        <option value="hot" {{ isset($data['data']['products']['state']) && $data['data']['products']['state'] == 'hot' ? 'checked' : '' }}>Nội dung nổi bật (HOT)</option>
                        <option value="random" {{ isset($data['data']['products']['state']) && $data['data']['products']['state'] == 'random' ? 'checked' : '' }}>Nội dung ngẫu nhiên (RANDOM)</option>
                        <option value="view" {{ isset($data['data']['products']['state']) && $data['data']['products']['state'] == 'view' ? 'checked' : '' }}>Nội dung được xem nhiều nhất (VIEW)</option>
                    </select>
                </div>
                <div class="form-group widget-items contents_show products_show">
                    <label>Số lượng mẫu tin</label>
                    <input class="form-control" name="txtWidgetQty" value="{{ isset($data['data']['contents']['qty']) ? $data['data']['contents']['qty'] : '' }}" placeholder="Số lượng bài viết hiển thi" />
                </div>
                <div class="form-group contents_show products_show">
                    <label>Số cột hiển thị</label>
                    <div class="fastselectbox1">
                        <input type="text" class="form-control  multipleSelect" name="sltWidgetColumn" value="" data-initial-value="" data-url="{{ url('api/widgetcolumns') }}" placeholder="Chọn số cột hiển thị....">
                    </div>
                </div>
                <div class="form-group">
                    <label>Thông tin hiển thị</label>
                    <hr />
                    <div class="form-group">
                        <input type="checkbox" name="txtWidgetShow[]" id="txtWidgetShowTitle" {{ isset($data['data']['contents']['w_title']) && $data['data']['contents']['w_title'] == 'widget_title' ? 'checked' : '' }} value="widget_title" class="minimal-red">
                        <label for="txtWidgetShowTitle"> Tiêu đề widget</label>
                    </div>
                    <div class="form-group widget-items widget_show default_show">
                        <input type="checkbox" name="txtWidgetShow[]" id="txtWidgetShowContent" {{ isset($data['data']['contents']['c_title']) && $data['data']['contents']['c_title'] == 'content_title' ? 'checked' : '' }} value="widget_contents" class="minimal-red">
                        <label for="txtWidgetShowContent"> Nội dung widget</label>
                    </div>
                    <div class="form-group widget-items contents_show products_show">
                        <input type="checkbox" name="txtWidgetShow[]" id="txtWidgetShowContentTitle" {{ isset($data['data']['contents']['c_title']) && $data['data']['contents']['c_title'] == 'content_title' ? 'checked' : '' }} value="content_title" class="minimal-red">
                        <label for="txtWidgetShowContentTitle"> Tiêu đề nội dung</label>
                    </div>
                    <div class="form-group widget-items contents_show products_show">
                        <input type="checkbox" name="txtWidgetShow[]" id="txtWidgetShowContentImage" {{ isset($data['data']['contents']['c_images']) && $data['data']['contents']['c_images'] == 'content_image' ? 'checked' : '' }} value="content_image" class="minimal-red">
                        <label for="txtWidgetShowContentImage"> Hình ảnh đại diện</label>
                    </div>
                    <div class="form-group widget-items contents_show products_show">
                        <input type="checkbox" name="txtWidgetShow[]" id="txtWidgetShowContentUpdate" {{ isset($data['data']['contents']['c_update']) && $data['data']['contents']['c_update'] == 'content_update' ? 'checked' : '' }} value="content_update" class="minimal-red">
                        <label for="txtWidgetShowContentUpdate"> Thông tin cập nhật (Người, Ngày giờ cập nhật)</label>
                    </div>
                    <div class="form-group widget-items contents_show products_show">
                        <input type="checkbox" name="txtWidgetShow[]" id="txtWidgetShowContentIntro" {{ isset($data['data']['contents']['c_intro']) && $data['data']['contents']['c_intro'] == 'content_intro' ? 'checked' : '' }} value="content_intro" class="minimal-red">
                        <label for="txtWidgetShowContentIntro"> Nội dung mô tả</label>
                    </div>
                    <div class="form-group widget-items contents_show products_show">
                        <input type="checkbox" name="txtWidgetShow[]" id="txtWidgetShowContentCategory" {{ isset($data['data']['contents']['c_type']) && $data['data']['contents']['c_type'] == 'content_type' ? 'checked' : '' }} value="content_type" class="minimal-red">
                        <label for="txtWidgetShowContentCategory"> Hiển thị chủ đề (danh mục)</label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Trạng thái</label>
                    <div class="form-group">
                        <div class="radio-box">
                            <div class="list-items">
                                <input type="radio" name="rdoWidgetStatus" id="chkOff" value="0">
                                <label for="chkOff">
                                    <span class="chkicon"></span> Tạm ẩn
                                </label>
                            </div>
                            <div class="list-items">
                                <input type="radio" name="rdoWidgetStatus" id="chkOn" checked value="1">
                                <label for="chkOn">
                                    <span class="chkicon"></span> Hiển thị
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Cấu hình hiển thị</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label>Widget Style</label>
                        <textarea class="form-control" name="txtWidgetStyle" rows="8">{{ isset($data['data']['default']['style']) ? $data['data']['default']['style'] : '' }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <button type="button" class="btn btn-primary btnSaveWidgetAction"><i class="fa fa-floppy-o"></i> Lưu lại</button>
                </div>
            </div>
        </div>
        <div class="clr"></div>
    </form>
</div>
@include('templates.'.$themes.'.admin.blocks.modalbox')
@endsection