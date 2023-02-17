<!-- MODAL BOX -->
<div id="open-modalbox" class="modal" data-easein="bounceIn" tabindex="-1" role="dialog">
    <form action="" name="frmModalBox" id="frmModalBox" method="POST">
        @include('templates.'.$themes.'.admin.blocks.formget_default')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tiêu đề</h5>
                </div>
                <div class="modal-body form-data">
                    <div class="form-group">
                        <div class="modal-alert"></div>
                        <div class="modal-message"></div>
                        <div class="modal-key"></div>
                    </div>
                    <div class="form-group">
                        <div class="modal_content"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div>
                        <span class="modal-button-action"></span>
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Đóng lại</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>