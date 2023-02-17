<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\GlobalController;

//CACHE APP MENU
use Facades\App\Repository\cacheFillable;

use App\SQLDatabase;

use Config, Auth;

class ModuleConfigController extends Controller
{

    private static $table               = 'fields_details';
    private static $table_moduleconfig  = 'module_configs';

    public function getJson(Request $request) {

        $status     = GlobalController::$warning;

        $data = [];

        if($request->ajax()) {

            $get    = json_decode($request->get);

            $form_get   = GlobalController::form_get_process($get);
            $pages      = $form_get['pages'];

            $condition  = [['pages', $pages]];

            //Set table
            GlobalController::set_table(static::$table);
            $sql = new SQLDatabase;

            $get_data = $sql->get_data('get', $condition);
            if($get_data) {
                foreach($get_data as $items) {
                    $data[] = [
                        'label' => $items->fdetail_label,
                        'name'  => $items->fdetail_name
                    ];
                }

                $status = GlobalController::$success;

            }

        }

        return response()->json([
            'status'    => $status,
            'data'      => $data
        ]);

    }

    /**
     * GET DATA FROM DATABASE
     * SHOW FORM UPDATE
     */
    public function loadDataUpdate(Request $request, $id) {

        $status         = GlobalController::$warning;
        $data           = [];
        $data_list      = []; //DS hiển thị tất cả trường của modules
        $data_detail    = []; //DS hiển thị chi tiết cấu hình từng trường module

        GlobalController::set_table(static::$table_moduleconfig);
        $sql    = new SQLDatabase;

        if($request->ajax()) {

            $condition = [['id', $id]];

            if(!empty($condition)) {

                $get_data   = $sql->get_data('first', $condition);

                if($get_data) {

                    //Xử lý order
                    $orderBy        = json_decode($get_data->order_by, true);
                    $moduleOrder    = isset($orderBy[0]) && $orderBy[0] != "" ? $orderBy[0] : 0;
                    $moduleSort     = isset($orderBy[1]) && $orderBy[1] != "" ? $orderBy[1] : 0;

                    //Xử lý detail
                    $moduleDetail   = json_decode($get_data->key_modules);
                    if(!empty($moduleDetail)) {
                        foreach ($moduleDetail as $d_items) {
                            $data_detail[]  = $d_items;
                        }
                    }

                    //SELECTED PAGES
                    $pages  = $get_data->pages;
                    $selected_pages = GlobalController::selected_pages($pages);


                    //GET FILLABLE
                    $getFillable    = cacheFillable::all($pages);
                    $fillableList   = isset($getFillable['data']) ? $getFillable['data'] : [];
                    $fillableDetail = isset($getFillable['detail']) ? $getFillable['detail'] : []; // Checked


                    $data = [
                        'moduleType'    => $pages,
                        'pageSelected'  => $selected_pages['pages'],
                        'pageInitial'   => $selected_pages['initial'],
                        'moduleName'    => $get_data->name,
                        'moduleLength'  => $get_data->page_length,
                        'moduleOrder'   => $moduleOrder,
                        'txtSort'       => $moduleSort
                    ];

                    $status         = GlobalController::$success;

                }

            }

        }

        return response()->json([
            'status'            => $status,
            'data'              => $data,
            'detail'            => $data_detail,
            'fillable'          => $fillableList,
            'fillablechecked'   =>  $fillableDetail
        ]);

    }

    /**
     * UPDATE DATA
     */
    public function postCreate(Request $request) {

        $status     = GlobalController::$warning;
        $alert      = Config::get('constants.alert.not_update');
        $message    = [];

        if($request->ajax()) {

            $moduleType     = $request->module_type;
            $moduleName     = GlobalController::stripTags($request->module_name);
            $moduleLength   = intval($request->module_length);
            $moduleOrder    = intval($request->module_order);
            $moduleSort     = $request->module_sort;
            $moduleDetail   = $request->module_details;

            //Kiểm tra điều kiện
            $updateCondition    = [['pages', $moduleType]];            

            if(empty($message)) {

                //Set table
                GlobalController::set_fillable(GlobalController::$moduleConfigFillable);
                GlobalController::set_table(static::$table_moduleconfig);
                $sql = new SQLDatabase;

                $update = $sql->update_or_create([
                    'pages'         => $moduleType,
                    'name'          => $moduleName,
                    'key_modules'   => $moduleDetail,
                    'page_length'   => $moduleLength,
                    'order_by'      => GlobalController::parse_json([$moduleOrder, $moduleSort]),
                    'show_pageing'  => 1,
                    'module_status' => 1
                ], $updateCondition);

                if($update) {

                    $status     = GlobalController::$success;
                    $alert      = Config::get('constants.modules.updated');

                }
                
            }

        }

        return response()->json([
            'status'    => $status,
            'alert'     => $alert,
            'message'   => $message
        ]);

    }
    
}
