<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\GlobalController;
use App\Http\Controllers\TranslationController;

//Load cache
use Facades\App\Repository\cacheLayout;

use App\SQLDatabase;

use Config;

class WidgetController extends Controller
{
    
    
    public static function loadWidgetData($condition='') {

        $data = [];

        GlobalController::set_fillable(GlobalController::$widgetFillable);
        GlobalController::set_table(GlobalController::$table_widget);
        $sql = new SQLDatabase;

        $get_widget     = $sql->get_data('get', $condition);

        if($get_widget) {

            foreach ($get_widget as $items) {

                $data[] = [
                    'id'    => $items->id,
                    'title' => $items->widget_title
                ];

            }

        }

        return $data;

    }


    /**
     * LẤY CÁC COLUMN ĐƯỢC HIỂN THỊ 
     */
    public static function loadColumnData($condition='') {

        $data = [];

        GlobalController::set_table(GlobalController::$table_fieldDetail);
        $sql = new SQLDatabase;

        $get_data = $sql->get_data('get', $condition);

        if($get_data) {

            foreach ($get_data as $items) {

                $data[] = [
                    'id'    => $items->id,
                    'title' => $items->fdetail_label
                ];

            }

        }

        return $data;

    }

    /**
     * LOAD WIDGET LIST
     */
    public function postJson(Request $request) {

        $status     = GlobalController::$warning;
        $message    = [];

        $data       = [];

        if($request->ajax()) {

            $pages  = $request->pages;
            $type   = $request->type;

            $cacheLayout    = cacheLayout::all();
            $pageID         = isset($cacheLayout[$pages]['pages']) ? $cacheLayout[$pages]['pages'] : '';

            switch ($type) {
                case 'columns':
                    $columnCondition    =  [];
                    if($pageID != '') {
                        $columnCondition    =  ['pages' => $pageID, 'fdetail_frontend' => 1];
                    }
                    $data   = self::loadColumnData($columnCondition);
                    break;
                default:
                    $widgetCondition    =  [];
                    $data   = self::loadWidgetData($widgetCondition);
                    break;

            }

            if(!empty($data)) {
                $status = GlobalController::$success;
            }

            return response()->json([
                'status'    => $status,
                'message'   => $message,
                'data'      => $data
            ]);


        }

    }
    
    
    //post widget
    public function postUpdate(Request $request) {

        $status     = GlobalController::$warning;
        $alert      = Config::get('constants.alert.not_update');
        $message    = [];

        if($request->ajax()) {

            //Get data
            $widget_id      = $request->widget_id;
            $widget_module  = $request->widget_module;
            $widget_title   = $request->widget_name;
            $widget_content = $request->widget_content;
            $widget_folder  = $request->widget_folder;
            $widget_type    = $request->widget_type; //danh mục
            $widget_state   = $request->widget_state; //new, view,...
            $widget_qty     = $request->widget_qty;
            $widget_status  = $request->widget_status;
            $widget_column  = $request->widget_column;
            $widget_style   = $request->widget_style;
            $widget_info    = $request->widget_show;

            //Điều kiện cập nhật
            $updateCondition    = [['id', $widget_id]];

            //XỬ LÝ DỮ LIỆU
            $update_data = [];

            if($widget_title != '') {
                $update_data    += ['widget_title' => $widget_title];
            }

            if($widget_module != '') {
                $update_data    += ['widget_module' => $widget_module];
            }

            if($widget_content != '') {
                $update_data    += ['widget_content' => $widget_content];
            }

            if($widget_type != '') {
                $update_data    += ['widget_type' => $widget_type];
            }

            if($widget_qty != '') {
                $update_data    += ['widget_qty' => $widget_qty];
            }

            if($widget_column != '') {
                $update_data    += ['widget_column' => $widget_column];
            }

            if($widget_style != '') {
                $update_data    += ['widget_style' => $widget_style];
            }

            if($widget_state != '') {
                $update_data    += ['widget_state' => $widget_state];
            }

            if($widget_folder != '') {
                $update_data    += ['widget_folder' => $widget_folder];
            }

            if($widget_info != '') {
                $update_data    += ['widget_info' => $widget_info];
            }

            if($widget_info != '') {
                $update_data    += ['widget_status' => $widget_status];
            }

            if(empty($update_data)) {
                $message[]  = TranslationController::translation(Config::get('constants.alert.data_update_empty'));
            }

            if($widget_module == '') {
                $message[]  = TranslationController::translation(Config::get('constants.alert.data_update_empty'));
            }

            if(empty($message)) {

                GlobalController::set_fillable(GlobalController::$widgetFillable);
                GlobalController::set_table(GlobalController::$table_widget);
                $sql = new SQLDatabase;

                $update = $sql->update_or_create($update_data, $updateCondition);

                if($update) {

                    $status = GlobalController::$success;
                    $alert  = Config::get('constants.alert.updated');

                }

            }

            return response()->json([
                'status'    => $status,
                'alert'     => TranslationController::translation($alert),
                'message'   => $message
            ]);

        }
        
    }

    /**
     * LOAD WIDGET EDIT
     */
    public function loadUpdateInfo(Request $request, $id) {

        $status     = GlobalController::$warning;
        $message    = [];

        $data       = [];

        GlobalController::set_table(GlobalController::$table_widget);
        $sql = new SQLDatabase;

        $widgetID   = $id;

        if($widgetID > 0) {

            //condition
            $widgetCondition    =  [
                ['id', $id]
            ];

            //get data
            $get_widget     = $sql->get_data('first', $widgetCondition);

            if($get_widget) {

                $widgetInfo     = json_decode($get_widget->widget_info, true);

                //selected category
                if($get_widget->widget_type != '') {
                    $cate_id            = intval($get_widget->widget_type);
                    $selected_category  = GlobalController::selected_category($cate_id);
                }

                if($get_widget->widget_column != '') {
                    $widget_column              = $get_widget->widget_column;
                    $selected_widget_column     = GlobalController::selected_data(GlobalController::$table_widgetColumns, ['widget_cols_key', 'widget_cols_name'], ['widget_cols_key' => $widget_column]);
                }

                $data = [
                    'widget_id'         =>  $id,
                    'widget_title'      =>  $get_widget->widget_title,
                    'widget_module'     =>  $get_widget->widget_module,
                    'widget_content'    =>  $get_widget->widget_content,
                    'cate_id'           =>  isset($selected_category['id']) ? $selected_category['id'] : '',
                    'cate_initial'      =>  isset($selected_category['initial']) ? $selected_category['initial'] : '',
                    'widcols_id'        =>  isset($selected_widget_column['id']) ? $selected_widget_column['id'] : '',
                    'widcols_initial'   =>  isset($selected_widget_column['initial']) ? $selected_widget_column['initial'] : '',
                    'widget_qty'        =>  $get_widget->widget_qty,
                    'widget_style'      =>  $get_widget->widget_style,
                    'widget_state'      =>  $get_widget->widget_state,
                    'widget_info'       =>  $widgetInfo,
                    'widget_folder'     =>  $get_widget->widget_folder,
                    'widget_by'         =>  $get_widget->widget_by,
                    'widget_status'     =>  $get_widget->widget_status,
                ];

            }

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


    /**
     * POST REMOVE
     */
    public function postRemove(Request $request) {

        $status     = GlobalController::$warning;
        $alert      = Config::get('constants.alert.not_update');
        $message    = [];

        if($request->ajax()) {

            //Get data
            $widget_id      = GlobalController::form_get_process(json_decode($request->get), 'id');

            if(intval($widget_id) == 0) {
                $message[]  = TranslationController::translation(Config::get('constants.alert.not_condition'));
            }

            if(empty($message)) {

                //Điều kiện cập nhật
                $updateCondition    = [['id', $widget_id]];

                GlobalController::set_table(GlobalController::$table_widget);
                $sql = new SQLDatabase;

                $update = $sql->remove_data($updateCondition);

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
