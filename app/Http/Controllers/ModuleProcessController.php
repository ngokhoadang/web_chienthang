<?php

namespace App\Http\Controllers;

use App\Http\Controllers\GlobalController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TranslationController;

use Illuminate\Http\Request;

use App\SQLDatabase;

use File, Config, Session;

use Facades\App\Repository\Fillable;

class ModuleProcessController extends Controller
{
    
    public function getList($module) {

        $titlePage = 'DANH SÁCH '.$module;

        //Themes
        $themes         = GlobalController::get_themes();
        $web_action     = GlobalController::get_web_action($module, GlobalController::$list);

        //CHECK AUTH
        $permission     = PermissionController::getAuth($module);

        $message        = []; //Hiển thị khi có lỗi
        $modules_config = [];

        $header_buttons = [];

        if(in_array(GlobalController::$permissionView, $permission)) {

            if(in_array(GlobalController::$permissionUpdate, $permission)) {
                $header_buttons[] = GlobalController::admin_button_header($module, GlobalController::$create);
            }

            $header_buttons[] = GlobalController::admin_button_header($module, GlobalController::$list);

            /**
             * CONFIG SHOW MODULES
             */
            $modules_config = GlobalController::getModuleConfig($module);
            if(isset($modules_config['error']) && !empty($modules_config['error'])) {
                foreach($modules_config['error'] as $items) {
                    $message[]  = $items;
                }
                $moduleView = 'errors';
                $pageView   = '404';
            } else {
                $moduleView = $module;
                $pageView   = 'list';
            }

        } else {

            $moduleView = 'errors';
            $pageView   = '403';

        }

        $view = GlobalController::get_view($moduleView, $pageView);

        return view($view, compact('themes', 'web_action', 'header_buttons', 'titlePage', 'permission', 'message', 'modules_config'));

    }

    //VIEW CREATE
    public function getCreate($module) {

        $titlePage  = 'THÊM MỚI '.$module;

        //Themes
        $themes     = GlobalController::get_themes();

        $web_action = GlobalController::get_web_action($module, GlobalController::$create);

        //CHECK AUTH
        $permission     = PermissionController::getAuth($module);

        $header_buttons = [];

        if(in_array(GlobalController::$permissionUpdate, $permission)) {

            $header_buttons[] = GlobalController::admin_button_header($module, GlobalController::$create);

            //Button view
            if(in_array(GlobalController::$permissionView, $permission)) {
                $header_buttons[] = GlobalController::admin_button_header($module, GlobalController::$list);
            }

            $moduleView = $module;
            $pageView   = 'form';

        } else {
            $moduleView = 'errors';
            $pageView   = '403';
        }

        $view       = GlobalController::get_view($moduleView, $pageView);

        return view($view, compact('web_action', 'header_buttons', 'themes', 'module', 'titlePage'));

    }

    //VIEW UPDATE
    public function getUpdate ($module, $id) {

        $titlePage  = 'CẬP NHẬT '.$module;

        $web_action = GlobalController::get_web_action($module, GlobalController::$update, $id);

        //themes
        $themes     = GlobalController::get_themes();

        //CHECK AUTH
        $permission     = PermissionController::getAuth($module);

        $header_buttons = [];

        if(in_array(GlobalController::$permissionUpdate, $permission)) {

            $header_buttons[] = GlobalController::admin_button_header($module, GlobalController::$create);

            //Button view
            if(in_array(GlobalController::$permissionView, $permission)) {
                $header_buttons[] = GlobalController::admin_button_header($module, GlobalController::$list);
            }

            $moduleView = $module;
            $pageView   = 'form';

        } else {
            $moduleView = 'errors';
            $pageView   = '403';
        }

        $view       = GlobalController::get_view($module, 'form');

        return view($view, compact('web_action', 'header_buttons', 'themes', 'module', 'titlePage'));

    }

    //GET LIST JSON
    public function listJson(Request $request, $module) {

        $fetcharr   = [];

        //SET TABLE -- open fields table
        GlobalController::set_table($module);
        $sql    = new SQLDatabase;

        //CHECK AUTH
        $permission     = PermissionController::getAuth($module);

        // $buttons        = '';
        // $viewbuttons    = '';
        // $groupbuttons   = '';
        
        $editButton     = Config::get('constants.buttons.edit'); //label edit button
        $deleteButton   = Config::get('constants.buttons.delete'); //label delete button

        if($request->ajax()) {

            $start      = $request->start;
            $lenght     = $request->length >= 0 ? $request->length : 10;
            $draw       = intval($request->draw);
            $search     = $request->search['value'];
            $serchColumn= $request->columns[0]['data']; //columns[0][data]
            
            $modules_config = GlobalController::getModuleConfig($module);
            $moduleKeys     = isset($modules_config['keys']) ? $modules_config['keys'] : []; //Các cột cần lấy trong database
            
            
            // print_r($moduleKeys);
            // exit();

            // if($viewbuttons != '') {

            //     $groupButtonItem    = '';
                
            //     if($groupbuttons != '') {
            //         $groupButtonItem = '<button type="button" class="btn btn-success btn-sml dropdown-toggle" data-toggle="dropdown">
            //                                 <span class="caret"></span>
            //                                 <span class="sr-only">Toggle Dropdown</span>
            //                             </button>
            //                             <ul class="dropdown-menu" role="menu">
            //                                 '.$groupbuttons.'
            //                             </ul>';
            //     }
            //     $buttons .= '<div class="btn-group">
            //                     '.$viewbuttons.'
            //                     '.$groupButtonItem.'
            //                 </div>';
            // }

            $condition = [
                'keySearch' => [$search, [$serchColumn]]
            ];

            $get_data = $sql->get_data('get', $condition, '*', [$start, $lenght]);
            if($get_data) {
                
                foreach($get_data as $key=>$items) {

                    $buttons        = '';
                    $viewbuttons    = '';
                    $groupbuttons   = '';

                    $id             = $items->id;
                    
                    //Xử lý buttons
                    if(in_array(GlobalController::$permissionUpdate, $permission)) {
                        $updateUrl  = GlobalController::get_url(['admin', $module, GlobalController::$permissionUpdate, $id.'?loadid='.$id]);
                        $viewbuttons .= '<a href="'.$updateUrl.'" class="btn btn-info btn-sml"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> '.TranslationController::translation($editButton).'</a>';
                    }
                    if(in_array(GlobalController::$permissionDelete, $permission)) {
                        $viewbuttons .= '<a href="#" class="btn btn-danger btn-sml btnRemoveAction" data-id="'.$id.'" data-type="'.$module.'"><i class="fa fa-trash-o" aria-hidden="true"></i> '.TranslationController::translation($deleteButton).'</a>';
                    }

                    if($viewbuttons != '') {

                        $groupButtonItem    = '';
                        
                        if($groupbuttons != '') {
                            $groupButtonItem = '<button type="button" class="btn btn-success btn-sml dropdown-toggle" data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    '.$groupbuttons.'
                                                </ul>';
                        }
                        $buttons = '<div class="btn-group">
                                        '.$viewbuttons.'
                                        '.$groupButtonItem.'
                                    </div>';
                    }

                    $field_data = [];
                    foreach ($moduleKeys as $keyItems) {
                        $field_data[$keyItems] = $items->$keyItems;
                    }
                    $field_data['buttons'] = $buttons;
                    $fetcharr[] = $field_data;
                }
            }

        }

        $countData  = $sql->get_data('count', $condition, 'id');

        return response()->json([
            'draw'              => $draw,
            'recordsTotal'      => $countData,
            'recordsFiltered'   => $countData,
            'data'              => $fetcharr
        ]);

    }


    /**
     * LOAD WIDGET EDIT
     */
    public function loadUpdateInfo(Request $request) {

        $status     = GlobalController::$warning;
        $message    = [];

        
        if($request->ajax()) {

            $get        = GlobalController::form_get_process(json_decode($request->get));
            $id         = $get['id'];
            $module     = $get['pages'];

            $getFillable= GlobalController::parse_Fillable($module, 'fillable');

            $data       = GlobalController::loadFirstDataSQL([
                ['id', $id]
            ], $module, $getFillable);

            print_r($getFillable);
            exit();

            if(!empty($data)) {
                $status = GlobalController::$success;
            }

        }

        return response()->json([
            'status'    => $status,
            'message'   => $message,
            'data'      => $data
        ]);

    }

    //UPDATE AND CREATE
    public function postUpdate(Request $request, $module) {

        $status     = GlobalController::$warning;
        $alert      = Config::get('constants.alert.not_update');
        $message    = [];

        //SET TABLE -- open fields table
        GlobalController::set_table($module);
        $feild_sql      = new SQLDatabase;

        $data = [];

        if($request->ajax()) {

            $types  = $request->type;
            $get    = json_decode($request->get);
            $data   = json_decode($request->data);
            $detail = json_decode($request->detail);

            $feilds_data    = [];
            $feilds_detail  = [];

            $fillable       = [];
            $fillable_detail= [];

            //LẤY THÔNG TIN CHI TIẾT
            foreach ($detail as $d_items) {

                foreach ($d_items as $key=>$dd_items) {

                    foreach ($dd_items as $ddd_items) {

                        $key_name                       = $ddd_items->name;
                        $feilds_detail[$key][$key_name] = $ddd_items->value;
                        
                        //Lọc Fillable cho bảng field_details
                        if(!in_array($key_name, $fillable_detail)) {
                            $fillable_detail[]              = $key_name;
                        }

                    }

                }

            }

            //LẤY ĐIỀU KIỆN -GET
            $form_get   = GlobalController::form_get_process($get);
            $id         = $form_get['id'];
            $type       = $form_get['type'];
            $themes     = $form_get['themes'];
            $pages      = $form_get['pages'];

            //Get form_data
            $get_form_data      = GlobalController::form_get_data($data, $module);
            $insert_condition   = $get_form_data['data']['get'];
            $insert_fillable    = $get_form_data['data']['fillable'];
            $insert_data        = $get_form_data['data']['data'];

            if(empty($insert_condition)) {
                $message[]  = Config::get('constants.alert.not_condition');
            }

            if(empty($insert_fillable)) {
                $message[]  = Config::get('constants.alert.fillable_empty');
            }

            if(empty($insert_data)) {
                $message[]  = Config::get('constants.alert.data_empty');
            }

            //Nếu tồn tại
            if(empty($message)) {

                //SET TABLE -- using table
                GlobalController::set_table('pages');
                GlobalController::set_fillable($insert_fillable);
                $sql        = new SQLDatabase;

                $update_data = $feild_sql->update_or_create($insert_data, $insert_condition);

                if($update_data) {

                    $status = GlobalController::$success;
                    $alert  = Config::get('constants.alert.updated');

                    //XÓA CACHE
                    // Cache config // Tự xóa vì cache khác với module
                    GlobalController::clearCache(GlobalController::$table_webConfig);
                    GlobalController::clearCache($pages);

                    // XÓA SESSION
                    Session::forget('banner_slide');
                    Session::forget('menu');

                    //XÓA CÁC SESSION
                    // Session::forget('menu');

                    // //SET TABLE -- fields_detail
                    // GlobalController::set_table($module.'_details');
                    // $feild_detail_sql   = new SQLDatabase;

                    // //LẤY THÔNG TIN CHI TIẾT
                    // foreach ($detail[0] as $d_items) {

                    //     foreach ($d_items as $dd_items) {
        
                    //         $key_name                   = $dd_items->name;
                    //         $feilds_detail[$key_name]   = $dd_items->value;
                    //         $fillable_detail[]      = $key_name;
        
                    //     }
        
                    // }
                    // //SET FIELDS TABLE
                    // GlobalController::set_fillable($fillable_detail);

                    // foreach ($feilds_detail as $detail_items) {
                        
                    //     $feild_detail_sql->create_data($detail_items);

                    // }

                }

            } else {
                $message[]  = Config::get('constants.field.empty');
            }
            

        }

        return response()->json([
            'status'    => $status,
            'alert'     => TranslationController::translation($alert),
            'message'   => $message
        ]);

    }

    /**
     * POST REMOVE
     */
    public function postRemove(Request $request) {

        $status     = GlobalController::$warning;
        $alert      = Config::get('constants.alert.not_update');
        $message    = [];

        if($request->ajax()) {

            //Get data
            $get            = json_decode($request->get);
            $get_id         = GlobalController::form_get_process($get, 'id');
            $get_modules    = GlobalController::form_get_process($get, 'modules');

            if(intval($get_id) == 0) {
                $message[]  = TranslationController::translation(Config::get('constants.alert.not_condition'));
            }

            if($get_modules == '') {
                $message[]  = TranslationController::translation(Config::get('constants.alert.not_condition'));
            }

            if(empty($message)) {

                //Điều kiện xóa dữ liệu
                $removeCondition    = [['id', $get_id]];

                GlobalController::set_table($get_modules);
                $sql    = new SQLDatabase;

                $update = $sql->remove_data($removeCondition);

                if($update) {

                    $status = GlobalController::$success;
                    $alert  = Config::get('constants.alert.removed');

                }

            }

            return response()->json([
                'status'    => $status,
                'alert'     => TranslationController::translation($alert),
                'message'   => $message
            ]);

        }

    }

}
