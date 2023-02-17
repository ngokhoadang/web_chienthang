<?php

return [
    'status'    => [
        'warning'   => 'warning',
        'success'   => 'success'
    ],
    'errors' => [
        '403'   => ''
    ],
    'alert' => [
        'permission_denied' => 'Lỗi! Bạn không có quyền thực hiện tính năng này',
        'table_notfound'    => 'Lỗi! Không tìm thấy bảng dữ liệu để cập nhật!',
        'not_update'        => 'system_failed_update',
        'update_empty'      => 'system_empty_data_update',
        'updated'           => 'system_updated',
        'removed'           => 'system_removed',
        'not_condition'     => 'system_not_condition',
        'data_update_empty' => 'system_data_update_empty',
        'password_empty'    => 'Mật khẩu chưa được cài đặt',
        'password_short'    => 'Mật khẩu quá ngắn',
        'duplicated'        => 'Thông tin này đã tồn tại trong hệ thống!',
        'user_duplicated'   => 'Tên đăng nhập hoặc Email đã tồn tại trong hệ thống!',
        'page_empty'        => 'Trang không tồn tại, vui lòng chọn Trang',
        'fillable_empty'    => 'Lỗi! các Trường (Fillable) dữ liệu không tồn tại',
        'data_empty'        => 'Lỗi! Dữ liệu vào không tồn tại',
        'request_block'     => 'Lỗi! Yêu cầu không được cấp phát, vui lòng thực hiện với yêu cầu khác',
        'field_short'       => 'Lỗi! Trường này quá ngắn',
        'folder_empty'      => 'Lỗi! Thư mục không được phép rỗng',
        'file_exists'       => 'Lỗi! File đã tồn tại trên hệ thống',
        'file_allow_ext'    => 'Lỗi! Định dạng cho phép upload File chưa được khai báo',
        'file_denied'       => 'system_file_denied',
        'file_empty'        => 'system_file_empty',
    ],
    'modules'   => [
        'updated'       => 'Cập nhật thành công!',
        'loaded'        => 'Tải dữ liệu thành công'
    ],
    'field'   => [
        'empty'       => 'Chưa có trường nào được tạo'
    ],
    'buttons'   => [
        'list'      => 'system_button_list',
        'create'    => 'system_button_create',
        'edit'      => 'system_button_edit',
        'delete'    => 'system_button_delete',
    ]
];