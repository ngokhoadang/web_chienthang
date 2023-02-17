<div class="form-group">
    <label>Custom fields</label>
    <div class="row">
        <div class="col-md-2">
            {{-- Fastselect list pages --}}
            <div class="form-data-input" data-type="input" data-name="themes">
                <input type="text" class="form-control" readonly name="themes" value="{{ $themes }}" />
            </div>
        </div>
        <div class="col-md-4">
            {{-- Fastselect list pages --}}
            <div class="form-data-input form-data-get" data-type="input" data-name="pages" data-key="pages">
                <input type="text" class="form-control multipleSelect" name="pages" id="sltChoosePages" data-url="{{ url('admin/pages/json') }}" placeholder="Chọn trang..." />
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-data-input" data-type="input" data-name="field_type">
                <select class="form-control" name="field_type">
                    <option value="pages">Trang</option>
                    <option value="modules">Modules</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <button type="button" class="btn btn-primary btnaddpageexpress"><i class="fa fa-plus-square"></i> Thêm trang nhanh</button>
        </div>
    </div>
</div>
{{-- <div class="form-group">
    <div class="auto-button-contents"></div>
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary btn-sm btnaddbuttonsexpress"><i class="fa fa-plus-square"></i> Thêm nút</button>
        </div>
    </div>
</div> --}}