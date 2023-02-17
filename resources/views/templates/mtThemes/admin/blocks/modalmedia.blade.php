<!-- MODAL BOX -->
<div id="modalMedia" class="modal" data-easein="bounceIn" tabindex="-1" role="dialog">
    <form action="upload.php" class="dropzone" id="UploadImages" method="post" enctype="multipart/form-data">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-picture-o" aria-hidden="true"></i> Thư viện hình ảnh</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="media-buttons">
                            <button type="button" class="addFolder btn btn-sm btn-success"><i class="fa fa-folder" aria-hidden="true"></i> Thêm thư mục</button>
                            <button type="button" class="addFile btn btn-sm btn-primary"><i class="fa fa-file" aria-hidden="true"></i> Thêm file</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="media-container">
                            <div class="media-column">
                                <ul>
                                    <li class="actived loadfile" data-id="1">
                                        <span class="media-icon"><i class="fa fa-folder" aria-hidden="true"></i>
                                        </span>
                                        <span class="media-name">Images</span>
                                        <ul>
                                            <li class="loadfile" data-id="1">
                                                <span class="media-icon"><i class="fa fa-folder" aria-hidden="true"></i>
                                                </span>
                                                <span class="media-name">Child Folder</span>
                                            </li>
                                            <li class="loadfile" data-id="1">
                                                <span class="media-icon"><i class="fa fa-folder" aria-hidden="true"></i>
                                                </span>
                                                <span class="media-name">Child Folder</span>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="loadfile" data-id="1">
                                        <span class="media-icon"><i class="fa fa-folder" aria-hidden="true"></i>
                                        </span>
                                        <span class="media-name">Contents</span>
                                    </li>
                                    <li class="loadfile" data-id="1">
                                        <span class="media-icon"><i class="fa fa-folder" aria-hidden="true"></i>
                                        </span>
                                        <span class="media-name">Products</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="media-column">
                                <div class="box-uploads">
                                    <input name="fileUploads" type="file" />
                                </div>
                            </div>
                        </div>
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