@extends('templates.'.$themes.'.admin.index')
@section('titlepage', $titlePage)
@include('templates.'.$themes.'.admin.blocks.webaction')
@section('content')
<div class="main-content">
    <div class="row">
        <div class="col-md-12">
            <form name="frmFormUpdate" id="frmFormUpdate" action="" method="POST">
                <input class="form-control" type="hidden" name="txtGroupId" value="{{ isset($data['data']['id']) ? $data['data']['id'] : '' }}" />
                <div class="col-md-6">
                    @if(isset($data) && !empty($data))
                        @foreach ($data as $key=>$items)
                            <div class="box">
                                <div class="box-body">
                                    <div class="form-group">
                                        <input class="form-control" readonly type="text" name="txtStyleName" value="{{ isset($items['style_name']) ? $items['style_name'] : '' }}" />
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="txtStyleFileReview[]" id="txtStyleFileReview{{ ($key + 1) }}" value="{{ isset($items['style_file']) ? $items['style_file'] : '' }}" />
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="file" name="txtStyleFile[]" id="txtStyleFile{{ ($key + 1) }}" value="{{ isset($items['style_name']) ? $items['style_name'] : '' }}" />
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary btn-sm btnWebStyleSaveAction" data-id="{{ ($key + 1) }}"><i class="fa fa-floppy-o"></i> Lưu lại</button>
                                        <button type="button" class="btn btn-danger btn-sm btnWebStyleRemoveAction" data-id="{{ ($key + 1) }}"><i class="fa fa-trash-o" aria-hidden="true"></i> Xóa file</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="clr"></div>
            </form>
        </div>
    </div>
</div>
@include('templates.'.$themes.'.admin.blocks.modalbox')
@endsection