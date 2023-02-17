<?php

namespace App\Http\Controllers;

use App\Http\Controllers\GlobalController;

use Illuminate\Http\Request;

use App\SQLDatabase;

use Config;

class PagesController extends Controller
{
    
    protected $table;

    public function __construct() {
        $this->table = 'pages';
    }
    
    /**
     * LẤY DS PAGES, SỬ DỤNG FAST SELECT
     */
    public function getJon() {

        //SET TABLE -- using table
        GlobalController::set_table($this->table);
        $sql        = new SQLDatabase;

        $data       = [];

        $get_data   = $sql->get_data('get');
        if($get_data) {
            foreach($get_data as $items) {
                $data[] = [
                    'value' => $items->page_modules,
                    'text'  => $items->page_title
                ];
            }
        }

        return response()->json($data);

    }

    
    //TẠO HOẶC CẬP NHẬT
    public function postCreate(Request $request) {

        $status = GlobalController::$warning;
        $alert  = Config::get('constants.alert.not_update');
        $message= [];

        $field_data = [];
        $fillable   = []; //Set fillable for table

        if($request->ajax()) {

            //Get data
            $type       = $request->type;
            $form_data  = json_decode($request->data);

            $form_get   = GlobalController::form_data_get($form_data[0]->get);
            $type       = $form_get['type'];
            $modules    = $form_get['modules'];

            $update_condition   = [];
            if($modules != '') {
                $update_condition[] = ['page_modules', $modules];
            }

            //Get form_data
            $get_form_data      = GlobalController::form_get_data($form_data);
            $update_fillable    = $get_form_data['data']['fillable'];
            $update_data        = $get_form_data['data']['data'];

            if(empty($update_condition)) {
                $message[]  = Config::get('constants.alert.not_condition');
            }

            if(empty($update_fillable)) {
                $message[]  = Config::get('constants.alert.fillable_empty');
            }

            if(empty($update_data)) {
                $message[]  = Config::get('constants.alert.data_empty');
            }

            if(empty($message)) {

                //SET TABLE -- using table
                GlobalController::set_table('pages');
                GlobalController::set_fillable($update_fillable);
                $sql        = new SQLDatabase;

                //NẾU THÊM MỚI THÌ KIỂM TRA TRÙNG
                $check_duplicate    = 0;
                if($type == GlobalController::$create) {
                    $check_duplicate = $sql->check_duplicate($update_condition);
                }

                if($check_duplicate == 0) {

                    //UPDATE DATA
                    $update = $sql->update_or_create($update_data, $update_condition);

                    if($update) {

                        //Add permission default
                        if(isset($update_data['page_title']) && $update_data['page_title'] != '') {

                            $permissionData = [
                                'data'      => ['name'=> $update_data['page_title'], 'value' => $modules],
                                'detail'    => GlobalController::$permissionDefault
                            ];

                            GlobalController::createPermission($permissionData);

                        }


                        $status = GlobalController::$success;
                        $alert  = Config::get('constants.modules.updated');
                    }
        
                } else {
                    $message[]  = Config::get('constants.alert.duplicated');
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
