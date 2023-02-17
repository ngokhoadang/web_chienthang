<?php

namespace App\Http\Controllers;

use App\Http\Controllers\GlobalController;

use Illuminate\Http\Request;

use App\SQLDatabase;

use File, Config;

class ArticleController extends Controller
{

    public function __construct() {

        //auto load

    }

    //GET LIST

    //POST CREATE
    //UPDATE AND CREATE
    public function postUpdate(Request $request, $module) {

        $status     = Config::get('constants.status.warning');
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

            //PARSE DATA
            if(!empty($data)) {
                foreach($data as $items) {

                    foreach($items->data as $data_items) {

                        $key_name               = $data_items->name;
                        $feilds_data[$key_name] = $data_items->value;
                        $fillable[]             = $key_name;

                    }

                    
                }
            }

            echo '<pre>';
            print_r($feilds_data);
            exit();

            //Nếu tồn tại
            if(count($fillable_detail) > 0) {

                //LẤY ĐIỀU KIỆN -GET
                $form_get   = GlobalController::form_get_process($get);
                $type       = $form_get['type'];
                $themes     = $form_get['themes'];
                $pages      = $form_get['pages'];

                //Set condition
                $update_condition = [];
                if($themes != '') {
                    $update_condition[] = ['themes', $themes];
                }
                if($pages != '') {
                    $update_condition[] = ['pages', $pages];
                }

                //PARSE DATA
                if(!empty($data)) {
                    foreach($data as $items) {
                        $key_name               = $items->name;
                        $feilds_data[$key_name] = $items->value;
                        $fillable[]             = $key_name;
                    }
                }

                //SET FIELDS TABLE
                GlobalController::set_fillable($fillable);

                $update_data = $feild_sql->update_or_create($feilds_data, $update_condition);

                if($update_data) {

                    // //SET TABLE -- fields_detail
                    GlobalController::set_table($module.'_details');
                    $feild_detail_sql   = new SQLDatabase;

                    //LẤY THÔNG TIN CHI TIẾT
                    foreach ($detail[0] as $d_items) {

                        foreach ($d_items as $dd_items) {
        
                            $key_name                   = $dd_items->name;
                            $feilds_detail[$key_name]   = $dd_items->value;
                            $fillable_detail[]      = $key_name;
        
                        }
        
                    }
                    //SET FIELDS TABLE
                    GlobalController::set_fillable($fillable_detail);

                    foreach ($feilds_detail as $detail_items) {
                        
                        $feild_detail_sql->create_data($detail_items);

                    }

                }

            } else {
                $message[]  = Config::get('constants.field.empty');
            }
            

        }

        return response()->json([
            'status'    => $status,
            'alert'     => $alert,
            'message'   => $message
        ]);

    }

}
