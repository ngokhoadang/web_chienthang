<!-- MODAL BOX -->
<div id="uploadBox" class="hide">
    <input type="hidden" name="hiddenFolderID" id="hiddenFolderID" value="0" />
    <div class="addfolder-form">
        <div class="media-addfolder-form hide">
            <div class="box">
                <div class="box-body">
                    <div class="form-group">
                        <div class="errors-alert"></div>
                        <div class="errors-message"></div>
                    </div>
                    <div class="form-group">
                        <label>Tên thư mục</label>
                        <input type="text" class="form-control" name="mediaFolderName" id="mediaFolderName" />
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btnaddfolderaction">Thêm thư mục</button>
                        <button class="pull-right btn btn-danger closeaddfolder">Đóng lại</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <h4 class="media-header">File manager</h4>
            <span class="media-close">x</span>
        </div>
        <div class="box-body">
            <div class="form-group">
                <div class="progress hide">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>
            </div>
            <div class="form-group dropzone-upload-media hide">
                <form action="{{ route('image.post') }}" class="dropzone" id="UploadImages" method="post" enctype="multipart/form-data">
                    <div class="media-upload align-center hide">
                        <img class="rounded" id="avatar" src="" alt="avatar">
                        <label for="imgUploads">
                            <div class="media-upload-icon"><i class="fa fa-upload" aria-hidden="true"></i></div>
                            <div class="media-upload-text">Kéo thả ảnh vào hoặc nhấp vào để tải ảnh lên</div>
                            <input type="file" class="sr-only" id="imgUploads" name="image" accept="image/*">
                        </label>
                    </div>
                </form>
            </div>
            <div class="form-group">
                <div class="media-buttons">
                    <button type="button" class="addFolder btn btn-sm btn-success"><i class="fa fa-folder" aria-hidden="true"></i> Thêm thư mục</button>
                    <button type="button" class="addFile btn btn-sm btn-primary"><i class="fa fa-file" aria-hidden="true"></i> Thêm file</button>
                    <button type="button" class="closeDropZone btn btn-sm btn-danger hide"><i class="fa fa-file" aria-hidden="true"></i> Đóng up ảnh</button>
                    <button type="button" class="useFile btn btn-sm btn-info"><i class="fa fa-check-square-o" aria-hidden="true"></i> Sử dụng hình ảnh</button>
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
                        <div class="file-list"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modalCropImage" class="modal in" data-easein="bounceIn"  data-target="#modalCropImage" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Crop</h4>
            </div>
            <div class="modal-body">
                <div class="image-container">
                    <img id="imgCrop" src="../../../public/uploads/avatar/1111-27478.jpg" data-name="1111-27478.jpg">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning rotate-left"><span class="fa fa-rotate-left"></span></button>
                <button type="button" class="btn btn-warning rotate-right"><span class="fa fa-rotate-right"></span></button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                <button type="button" class="btn btn-primary cropUpload">Hoàn thành</button> 
            </div>
        </div>
    </div>
</div>