<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\GlobalController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TranslationController;

use App\SQLDatabase;
use App\Field_detail;

use Config;

class LayoutController extends Controller
{
    
    /**
     * GET LIST
     */
    public function getList() {

        $titlePage  = 'THÊM MỚI: HEADER - FOOTER';

        //Themes
        $themes     = GlobalController::get_themes();

        //CHECK AUTH
        $permission     = PermissionController::getAuth('layouts');

        $header_buttons = [];

        if(in_array(GlobalController::$permissionView, $permission)) {

            // $header_buttons[] = GlobalController::admin_button_header('layoutconfigs', GlobalController::$setting.'?st=header', 'Thiết lập HEADER', 'btn btn-primary  btn-sm', '<i class="fa fa-cog" aria-hidden="true"></i>');
            // $header_buttons[] = GlobalController::admin_button_header('layoutconfigs', GlobalController::$create, 'Thiết lập BODY', 'btn btn-warning  btn-sm', '<i class="fa fa-cog" aria-hidden="true"></i>');
            // $header_buttons[] = GlobalController::admin_button_header('layoutconfigs', GlobalController::$setting.'?st=footer', 'Thiết lập FOOTER', 'btn btn-success  btn-sm', '<i class="fa fa-cog" aria-hidden="true"></i>');

            $moduleView = 'layoutconfigs';
            $pageView   = 'list';

        } else {
            $moduleView = 'errors';
            $pageView   = '403';
        }

        $web_action = GlobalController::get_web_action($moduleView, GlobalController::$list);

        $view       = GlobalController::get_view($moduleView, $pageView);

        return view($view, compact('header_buttons','themes', 'web_action', 'titlePage'));

    }
    
    //GET HEADER
    public function getHeader() {

        $titlePage  = 'THÊM MỚI: HEADER - FOOTER';

        $st         = isset($_GET['st']) ? $_GET['st'] : '';
        $module     = 'layoutconfigsheaderfooter';

        //Themes
        $themes     = GlobalController::get_themes();

        $web_action = GlobalController::get_web_action($module, GlobalController::$create, $st);

        $loadForm   = true;

        $pages      = [];

        switch($st) {
            case 'header':
            case 'footer':
                $layout_pages = 'default';
                break;
            default:
                $loadForm   = false;
                break;
        }

        if($loadForm) {

            GlobalController::set_table(GlobalController::$table_layout);
            $sql            = new SQLDatabase;

            $get_layout     = $sql->get_data('first', ['pages' => $layout_pages]);
            if($get_layout) {
                $pages  = [
                    'id'    => $get_layout->id,
                    'title' => $get_layout->name
                ];
            }

            //CHECK AUTH
            $permission     = PermissionController::getAuth('layouts');

            $header_buttons = [];

            if(in_array(GlobalController::$permissionUpdate, $permission)) {

                $header_buttons[] = GlobalController::admin_button_header('layoutconfigs', GlobalController::$list, 'Danh sách');
                $header_buttons[] = GlobalController::admin_button_header('layoutconfigs', GlobalController::$setting.'?st=header', 'Thiết lập HEADER', 'btn btn-success  btn-sm', '<i class="fa fa-cog" aria-hidden="true"></i>');
                $header_buttons[] = GlobalController::admin_button_header('layoutconfigs', GlobalController::$create, 'Thiết lập BODY', 'btn btn-warning  btn-sm', '<i class="fa fa-cog" aria-hidden="true"></i>');
                $header_buttons[] = GlobalController::admin_button_header('layoutconfigs', GlobalController::$setting.'?st=footer', 'Thiết lập FOOTER', 'btn btn-info  btn-sm', '<i class="fa fa-cog" aria-hidden="true"></i>');

                //Button view
                if(in_array(GlobalController::$permissionView, $permission)) {
                    // $header_buttons[] = GlobalController::admin_button_header($module, GlobalController::$list);
                }

                $moduleView = 'layoutconfigs';
                $pageView   = 'header_footer';

            } else {
                $moduleView = 'errors';
                $pageView   = '403';
            }

        } else {
            $moduleView = 'errors';
            $pageView   = '403';
        }

        $view       = GlobalController::get_view($moduleView, $pageView);

        return view($view, compact('header_buttons','themes', 'web_action', 'titlePage', 'pages'));

        
    }
    
    
    public function postCreate(Request $request) {

        $themes         = GlobalController::get_themes();

        $status         = GlobalController::$warning;
        $alert          = Config::get('constants.alert.not_update');
        $message        = [];

        $layoutData     = [];

        if($request->ajax()) {

            $form_data  = json_decode($request->data); //Data layout

            //Get form_data
            $get_form_data      = GlobalController::form_get_data($form_data);
            $update_fillable    = $get_form_data['data']['fillable'];
            $update_get         = $get_form_data['data']['get'];
            $update_data        = $get_form_data['data']['data'];

            //GET CONDITION
            $themes             = isset($update_data['themes']) ? $update_data['themes'] : '';
            $pages              = isset($update_data['pages']) ? $update_data['pages'] : '';

            if(!isset($update_get['id']) && intval($update_get['id']) == 0) {
                $message[]  = TranslationController::translation(Config::get('constants.alert.not_condition'));
            }

            if(empty($message)) {

                //Lấy layoutID
                $layoutID           = $update_get['id'];

                $headerData         = json_decode($request->layout_header);
                $bodyData           = json_decode($request->layout_body);
                $footerData         = json_decode($request->layout_footer);

                //Update layout
                GlobalController::set_fillable($update_fillable);
                GlobalController::set_table(GlobalController::$table_layout);
                $sql    = new SQLDatabase;

                $update = $sql->update_or_create($update_data, $update_get);

                if($update) {

                    GlobalController::set_fillable(['layout_id', 'block']);
                    GlobalController::set_table('layout_blocks');
                    $blockSQL = new Field_detail;

                    if(!empty($headerData)) {

                        $this->insertData($layoutID, $headerData, 'header');

                    }

                    if(!empty($bodyData)) {

                        $this->insertData($layoutID, $bodyData, 'body');

                    }

                    if(!empty($footerData)) {

                        $this->insertData($layoutID, $footerData, 'footer');

                    }

                    $status = GlobalController::$success;
                    $alert  = Config::get('constants.alert.updated');

                }

            }

        }

        return response()->json([
            'status'    => $status,
            'alert'     => TranslationController::translation($alert),
            'message'   => $message
        ]);

    }

    /**
     * TẢI DỮ LIỆU, HIỂN THỊ GIAO DIỆN
     */
    public function postJson(Request $request) {

        $status     = GlobalController::$warning;

        $data       = [];

        if($request->ajax()) {

            GlobalController::set_table(GlobalController::$table_layout);
            $sql    = new SQLDatabase;

            $get    = json_decode($request->get);
            $st     = isset($request->st) ? [$request->st] : 'body';

            //LẤY ĐIỀU KIỆN -GET
            $form_get   = GlobalController::form_get_process($get);
            $layoutID   = $form_get['id']; //Layout id
            $themes     = $form_get['themes'];
            $pages      = $form_get['pages'];

            $data       = GlobalController::getLayoutBlock($layoutID, $st);
            // $data       = GlobalController::showLayoutData('default', $st);

            // $layout_config = $this->getLayoutConfig($layoutID);
            // $layout_config = [];

            if(!empty($data)) {
                $status     = GlobalController::$success;
            }

        }

        return response()->json([
            'status'    => $status,
            'data'      => $data,
            // 'layout'    => $layout_config
        ]);

    }

    /**
     * GET LAYOUT CONFIG
     */
    public function getLayoutConfig($layoutDetailID) {

        GlobalController::set_table(GlobalController::$table_layoutconfig);
        $sql        = new SQLDatabase;

        $data       = [];

        $get_layout = $sql->get_data('get', ['layout_detail_id'=>$layoutDetailID]);

        if($get_layout) {

            foreach ($get_layout as $items) {

                $widgetID   = $items->widget_id;

                $widget_title   = GlobalController::getWidget($widgetID, 'widget_title');

                $data[] = [
                    'layout_detail_id'  => $layoutDetailID,
                    'layout_id'         => $items->layout_id,
                    'widget_id'         => $widgetID,
                    'widget_title'      => $widget_title,
                    'content_column'    => $items->content_column,
                    'modules'           => $items->modules,
                    'type'              => $items->type,
                    'position_show'     => $items->position_show,
                ];

            }

        }

        return $data;

    }

    /**
     * GET LAYOUT BLOCK
     */
    public function getLayoutBlock($layoutID, $blockType='') {

        $layoutData = [];

        GlobalController::set_table(GlobalController::$table_layout_blocks);
        $sql = new SQLDatabase;

        $get_layout = $sql->get_data('get', ['layout_id'=>$layoutID]);

        if($get_layout) {
    
            foreach ($get_layout as $items) {

                $block_id   = $items->id;
                $block_type = $items->block;

                $layoutBlock = [
                    'id'    => $block_id,
                    'block' => $block_type
                ];

                //Layout_detail
                GlobalController::set_table(GlobalController::$table_layout_details);
                $detailSQL = new SQLDatabase;

                $layoutDetail = [];

                $get_layout_detail = $detailSQL->get_data('get', ['block_id' => $block_id]);

                if($get_layout_detail) {

                    foreach ($get_layout_detail as $detailItems) {

                        $detailID       = $detailItems->id;
                        $detailClass    = $detailItems->layout_class;

                        $layoutDetail[] = [
                            'id'            => $detailID,
                            'class'         => $detailClass,
                            'layout_config' => $this->getLayoutConfig($detailID)
                        ];

                    }

                }

                $layoutData[$block_type][] = [
                    'block'     => $layoutBlock,
                    'detail'    => $layoutDetail
                ];

            }

        }

        return $layoutData;

    }

    /**
     * INSERT DATA
     * $model: Model
     */
    public function insertData($layout_id, $data, $type="header") {

        $list_block_id  = []; //Đặt giá trị để xóa dữ liệu ko tồn tại

        if(!empty($data)) {

            foreach ($data as $keys=>$items) {

                $block_id   = $items->block_id;
                $rowsValue  = $items->values;

                //Block sql
                GlobalController::set_fillable(['layout_id', 'block']);
                GlobalController::set_table('layout_blocks');
                $blockSQL = new SQLDatabase;

                $list_block_id[]    = $block_id;

                $update = $blockSQL->update_or_create([
                    'layout_id' => $layout_id,
                    'block'     => $type
                ], ['id' => $block_id]);

                if($update) {

                    //Nếu ko có block_id, nghĩa là thêm mới, thì lấy block_id mới nhất
                    if($block_id == '') {
                        $block_id           = $blockSQL->get_max_id();
                        $list_block_id[]    = $block_id;
                    }

                    if(!empty($rowsValue)) {

                        foreach ($rowsValue as $detailItems) {

                            $detail_id      = $detailItems->id;
                            $detail_value   = $detailItems->value;

                            //Detail sql
                            GlobalController::set_fillable(['block_id', 'layout_class']);
                            GlobalController::set_table('layout_details');
                            $detailSQL = new SQLDatabase;

                            $detailSQL->update_or_create([
                                'block_id'      => $block_id,
                                'layout_class'  => $detail_value
                            ], ['id'  => $detail_id]);

                        }

                    }

                }

            }

        }

        $this->removeLayoutCancel($layout_id, $list_block_id, $type);

    }

    /**
     * XÓA DỮ LIỆU LAYOUT KO CẦN THIẾT (NGHĨA LÀ CÁI MÀ MÌNH ĐÃ XÓA BỎ KHI THIẾT LẬP LAYOUT)
     * $type: header, body hay footer, để tránh trường hợp phải xóa hết các phần khác của giao diện
     */
    public function removeLayoutCancel($layout_id, $list_block_id, $type) {
        //Block sql
        GlobalController::set_table('layout_blocks');
        $blockSQL = new SQLDatabase;

        //Tìm và xóa dữ liệu ko còn tồn tại
        $blockCondition     = [
            'where' => [
                ['layout_id', $layout_id],
                ['block', $type]
            ],
            'whereNotIn'    => ['id' => $list_block_id]
        ];
        $remove_block_id    = [];
        $get_block_data     = $blockSQL->get_data('get', $blockCondition);
        if($get_block_data) {
            foreach($get_block_data as $rb_items) {

                $blockID    = $rb_items->id;

                //Xóa layout_block
                $remove = $blockSQL->remove_data(['id' => $blockID]);

                //Xóa layout_details
                if($remove) {
                    $this->removeLayoutDetails($blockID);
                }

            }
        }

    }

    /**
     * REMOVE LAYOUT DETAIL
     * $blockID: is array, list id block
     */
    public function removeLayoutDetails($blockID) {

        //Detail sql
        GlobalController::set_table('layout_details');
        $detailSQL = new SQLDatabase;

        $detailSQL->remove_data(['block_id' => $blockID]);

    }


    /**
     * LAYOUT CONFIG
     * CẬP NHẬT HIỂN THỊ GIAO DIỆN WEBSITE
     */
    public function layoutConfigUpdate(Request $request) {

        $status     = GlobalController::$warning;
        $alert      = Config::get('constants.alert.not_update');
        $message    = [];
        $failed_job = [];

        if($request->ajax()) {

            $layout_config  = json_decode($request->layout_config);
            $layout_page    = $request->layout_page; //pages: header, footer, body
            $layout_module  = $request->layout_module; //modules: layout_id

            if($layout_page == '') {
                $message[]  = Config::get('constants.alert.data_update_empty');
            }

            if(empty($layout_config)) {
                $message[]  = Config::get('constants.alert.data_empty');
            }


            if(empty($message)) {

                GlobalController::set_fillable(GlobalController::$layoutConfigFillable);
                GlobalController::set_table(GlobalController::$table_layoutconfig);
                $sql        = new SQLDatabase;

                //Xóa dữ liệu cũ
                $sql->remove_data([
                    'content_column'    => $layout_page,
                    'modules'           => $layout_module
                ]);

                foreach ($layout_config as $key=>$items) {

                    $update_data    = [
                        'layout_detail_id'  => $items->detail_id,
                        'widget_id'         => $items->widget_id,
                        'content_column'    => $layout_page,
                        'modules'           => $layout_module,
                        'type'              => $items->type,
                        'position_show'     => $items->position_show
                    ];

                    $updated = $sql->update_or_create($update_data, ['id'=>NULL]);

                    if($updated) {
                        $failed_job[]   = GlobalController::$success;
                    } else {
                        $failed_job[]   = GlobalController::$warning;
                    }

                }
                

                if(!in_array(GlobalController::$warning, $failed_job)) {
                    $status     = GlobalController::$success;
                    $alert      = Config::get('constants.alert.updated');
                }

            }            

        }

        return response()->json([
            'status'    => $status,
            'alert'     => TranslationController::translation($alert),
            'message'   => $message
        ]);

    }

    /**
     * TẢI DATA UPDATE
     */
    public function getDataUpdate(Request $request) {

        $status     = GlobalController::$warning;
        $alert      = Config::get('constants.alert.not_update');
        $message    = [];

        $layoutInfo = [];

        if($request->ajax()) {

            if(empty($message)) {

                $get    = json_decode($request->get);

                //LẤY ĐIỀU KIỆN -GET
                $form_get   = GlobalController::form_get_process($get);
                $layoutID   = $form_get['id']; //Layout id
                $themes     = $form_get['themes'];
                $pages      = $form_get['pages'];

                GlobalController::set_table(GlobalController::$table_layout);
                $sql        = new SQLDatabase;

                //Lấy layout pages từ layout_id
                $layout_name    = '';
                $layout_id      = '';
                $get_layout     = $sql->get_data('first', ['id' => $layoutID]);
                if($get_layout) {

                    $layout_id          = $get_layout->id;
                    $layout_name        = $get_layout->name;
                    $layout_pages       = $get_layout->pages;
                    $selected_layout    = GlobalController::selected_pages($layout_pages);

                }

                $data               = GlobalController::getLayoutBlock($layoutID);                

            }            

        }

        if(!empty($data)) {
            $status     = GlobalController::$success;
        }

        return response()->json([
            'status'        => $status,
            'alert'         => TranslationController::translation($alert),
            'layout_id'     => $layout_id,
            'layout_name'   => $layout_name,
            'layout_pages'  => isset($selected_layout['pages']) ? $selected_layout['pages'] : '',
            'layout_initial' => isset($selected_layout['initial']) ? $selected_layout['initial'] : '',
            'data'          => $data
        ]);

    }



    /*
     |===============================================================================================
     |  LAYOUT CONFIG - SHOW LAYOUT IN WEBSITE
     |  * TẢI VÀ HIỂN THỊ GIAO DIỆN WEBSITE NGƯỜI DÙNG
     |===============================================================================================
     */

}
