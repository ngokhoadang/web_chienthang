<?php

namespace App\Http\Controllers;

use App\Http\Controllers\GlobalController;

use Illuminate\Http\Request;

use App\SQLDatabase;
use App\SQLGroupDatabase;
use App\Field_detail;
use App\Table_Fillable;

use Config;

class FieldController extends Controller
{

    protected $table, $tb_detail, $tb_group;
    public static $value;

    public function __construct() {
        // new GlobalController;    
        $this->table        = 'fields';
        $this->tb_detail    = $this->table.'_details';
        $this->tb_group     = $this->table.'_groups';
    }

    //GET JSON, LOAD FOR MODULE
    public function getJson(Request $request) {

        $status     = GlobalController::$warning;
        $data       = [];

        if($request->ajax()) {
            
            $get        = json_decode($request->get);

            //LẤY ĐIỀU KIỆN -GET
            $form_get   = GlobalController::form_get_process($get);
            $themes     = $form_get['themes'];
            $pages      = $form_get['pages'];

            
            $condition  = [['themes', $themes]];
            if(isset($pages) && $pages != '') {
                $condition[]    =  ['pages', $pages];
            }

            GlobalController::set_table($this->table);
            $field_sql          = new SQLDatabase;

            GlobalController::set_table($this->tb_detail);
            $field_detail_sql   = new SQLDatabase;

            GlobalController::set_table($this->tb_group);
            $field_group_sql   = new SQLDatabase;

            $get_fields = $field_sql->get_data('get', $condition);

            //Get detail
            $field_list     = [];
            $getFieldDetail = $field_detail_sql->get_data('get', $condition, '*', '', GlobalController::$sortFieldList);
            if($getFieldDetail) {
                foreach ($getFieldDetail as $key=>$detail_items) {

                    $field_id           = $detail_items->id;
                    $field_key          = $detail_items->fdetail_name;
                    $field_label        = $detail_items->fdetail_label;
                    $field_type         = $detail_items->fdetail_type;
                    $field_required     = $detail_items->fdetail_required == 'required' ? true : false;
                    $field_placeholder  = $detail_items->fdetail_placeholder;
                    $field_editor       = $detail_items->fdetail_editor;
                    $field_description  = $detail_items->fdetail_description;
                    $field_multiple     = $detail_items->fdetail_multiple;
                    $field_baseurl      = $detail_items->fdetail_modules;
                    $field_column       = $detail_items->fdetail_column;

                    //Detail
                    $options        = [];
                    $get_groups     = $field_group_sql->get_data('get', ['fdetail_id' => $field_id]);
                    if($get_groups) {
                        foreach ($get_groups as $group_items) {
                            $options[]  = [
                                'name'      => $group_items->fieldgroup_item,
                                'value'     => $group_items->fieldgroup_value,
                                'selected'  => $group_items->fieldgroup_type,
                            ];
                        }
                    }

                    $field_list[$field_key]   = [
                        'label'         => $field_label,
                        'type'          => $field_type,
                        'empty'         => $field_required,
                        'class'         => 'form-control',
                        'modules'       => $field_type,
                        'column'        => $field_column,
                        'value'         => '',
                        'placeholder'   => $field_placeholder,
                        'editor'        => $field_editor,
                        'description'   => $field_description,
                        'multiple'      => $field_multiple,
                        'baseurl'       => $field_baseurl,
                        'options'       => $options
                    ];
                }
            }

            if(!empty($field_list)) {

                $data   = [
                    'feilds'=> $field_list
                ];
    
                $status     = GlobalController::$success;
                
            }

        }
        
        return response()->json([
            'status'    => $status,
            'data'      => $data
        ]);


    }

    //GET LIST DATA
    public function getInfo(Request $request) {

        $status     = GlobalController::$warning;
        $alert      = Config::get('constants.alert.not_update');
        $message    = [];

        $data       = [];
        $detail     = [];

        $get_flag   = false;

        if($request->ajax()) {

            $get        = json_decode($request->get, true);

            //LẤY ĐIỀU KIỆN -GET
            $form_get   = GlobalController::form_get_process($get);
            $type       = $form_get['type'];
            $themes     = $form_get['themes'];
            $pages      = $form_get['pages'];

            //1. SET TABLE - OPEN CLASS
            GlobalController::set_table($this->table);
            $field_sql  = new SQLDatabase;

            //2. LẤY ĐIỀU KIỆN
            $condition = [];
            if($themes != '') {
                $condition[] = ['themes', $themes];
            }
            if($pages != '') {
                $condition[] = ['pages', $pages];
            }

            $whereCondition = [
                'where' => $condition
            ];

            //3. KIỂM TRA ĐIỀU KIỆN
            if($pages == '') {
                $message[]  = Config::get('constants.alert.page_empty');
            }

           

            if(empty($message)) {
                
                $get_data = $field_sql->get_data('first', $whereCondition);

                if(!empty($get_data)) {

                    $data   = [
                        'themes'    => $get_data->themes
                    ];

                    //LẤY THÔNG TIN CHI TIẾT
                    //1. SET TABLE - OPEN CLASS
                    GlobalController::set_table($this->tb_detail);
                    $field_detail_sql  = new SQLDatabase;

                    GlobalController::set_table($this->tb_group);
                    $field_group_sql  = new SQLDatabase;

                    //2. LẤY ĐIỀU KIỆN
                    //(Lấy điều kiện của themes, pages: giống với điều kiện ở trên)

                    //3. LẤY DỮ LIỆU
                    $get_detail = $field_detail_sql->get_data('get', $whereCondition, '*', '', GlobalController::$sortFieldList);

                    if($get_detail) {
                        
                        foreach ($get_detail as $d_items) {

                            $detail_id  = $d_items->id;

                            //Get GROUP FIELD
                            $fieldGroupData = [];

                            $get_groups     = $field_group_sql->get_data('get', ['fdetail_id'=>$detail_id]);
                            
                            if($get_groups) {

                                foreach ($get_groups as $gItems) {

                                    $fieldGroupData[] = [
                                        'fdetail_id'        => $detail_id,
                                        'fieldgroup_item'   => $gItems->fieldgroup_item,
                                        'fieldgroup_value'  => $gItems->fieldgroup_value,
                                        'fieldgroup_type'   => $gItems->fieldgroup_type,
                                        'fieldgroup_select' => $gItems->fieldgroup_select,
                                    ];

                                }

                            }

                            $detail[]   = [
                                'id'                    => $detail_id,
                                'themes'                => $d_items->themes,
                                'pages'                 => $d_items->pages,
                                'fdetail_label'         => $d_items->fdetail_label,
                                'fdetail_name'          => $d_items->fdetail_name,
                                'fdetail_type'          => $d_items->fdetail_type,
                                'fdetail_description'   => $d_items->fdetail_description,
                                'fdetail_placeholder'   => $d_items->fdetail_placeholder,
                                'fdetail_required'      => $d_items->fdetail_required,
                                'fdetail_modules'       => $d_items->fdetail_modules,
                                'fdetail_multiple'      => $d_items->fdetail_multiple,
                                'fdetail_frontend'      => $d_items->fdetail_frontend,
                                'fdetail_order'         => $d_items->fdetail_order,
                                'groups'                => $fieldGroupData
                            ];

                        }

                    }

                    $status = GlobalController::$success;

                }
            }

        }

        return response()->json([
            'status'    => $status,
            'alert'     => $alert,
            'data'      => $data,
            'detail'    => $detail
        ]);


    }

    //get set function
    public static function set_value($value) {
        static::$value = $value;
    }

    public static function get_value() {
        return static::$value;
    }

    /**
     * THIẾT LẬP FILLABLE
     */
    public static function setFillable($columnArr, $typeArr='') {

        $data = [];

        if($typeArr != '') {

            foreach ($columnArr as $key=>$items) {

                $data[$items] = isset($typeArr[$key]) ? $typeArr[$key] : '';

            }

        }

        return [
            'fillable'      => $columnArr,
            'fillandtype'   => $data
        ];

    }
    
    //CREATE OR UPDATE
    public function postUpdate(Request $request) {

        $table_fillable = new Table_Fillable;

        $status     = GlobalController::$warning;
        $alert      = Config::get('constants.alert.not_update');

        $message    = [];     

        $data = [];

        if($request->ajax()) {

            $types          = $request->type;
            
            //Form data
            $form_data      = json_decode($request->data);
            $data           = isset($form_data[0]->data) ? $form_data[0]->data : [];

            //Form detail and Group
            $form_detail    = json_decode($request->detail);           

            $feilds_data    = [];
            $feilds_detail  = [];
            $feilds_groups  = [];

            $fillable       = [];
            $fillable_detail= [];
            $fillable_column= ['id']; //Các trường cho bảng để sử dụng để hiển thị danh sách
            $fillable_type  = ['default']; //Các trường và kiểu dữ liệu của trường đó

            $update_flag  = false;

            /**
             * LẤY VÀ XỬ LÝ DỮ LIỆU VÀO
             */
            //LẤY ĐIỀU KIỆN -GET
            $form_get   = GlobalController::form_data_get($form_data[0]->get);
            $type       = $form_get['type'];
            $themes     = $form_get['themes'];
            $pages      = $form_get['pages'];

            // LẤY DỮ LIỆU
            
            if(!empty($data)) {
                foreach($data as $items) {
                    $key_name               = $items->name;
                    $feilds_data[$key_name] = $items->value;
                    $fillable[]             = $key_name;
                }
            }

            //LẤY DỮ LIỆU CHI TIẾT
            foreach ($form_detail as $key=>$d_items) {

                //PARSE DETAIL CONDITION
                $detail_update_condition    = [];
                $detail_update_data         = [];

                if(isset($d_items->get) && isset($d_items->data)) {

                    foreach ($d_items->get as $rowsKey=>$g_items) {

                        foreach ($g_items as $gKey=>$gValue) {
    
                            $detail_update_condition[]   = [$gKey, $gValue];
    
                        }
    
                    }

                    //PARSE DETAIL DATA
                    foreach ($d_items->data as $dd_items) {

                        /**
                         * LẤY CÁC FILLABLE CỦA BẢNG DỮ LIỆU ĐỂ THÊM VÀO CSDL
                         * -- Dựa vào field_name để xác định
                         */
                        if($dd_items->name == 'fdetail_name') {
                            $fillable_column[]   = $dd_items->value;
                        }

                        if($dd_items->name == 'fdetail_type') {
                            $fillable_type[]  = $dd_items->value;
                        }
                        

                        $key_name                       = $dd_items->name;
                        $key_value                      = isset($dd_items->value) ? $dd_items->value : '1a1a1a';
                        $detail_update_data[$key_name]  = $key_value;

                        //Lọc Fillable cho bảng field_details
                        if(!in_array($key_name, $fillable_detail)) {
                            $fillable_detail[]  = $key_name;
                        }

                    }

                    $feilds_detail[]    = [
                        'condition' => $detail_update_condition,
                        'data'      => $detail_update_data
                    ];

                }

            }

            /**
             * KIỂM TRA ĐIỀU KIỆN
             */
            //KIỂM TRA TỒN TẠI THEMES VÀ PAGES
            if($pages == '') {
                $message[]  = Config::get('constants.alert.page_empty');
            }

            if(empty($feilds_detail)) {
                $message[]  = Config::get('constants.field.empty');
            }


            //CHO PHÉP CẬP NHẬT
            if(empty($message)) {

                //1. SET TABLE - OPEN CLASS
                GlobalController::set_table($this->table);
                GlobalController::set_fillable($fillable);
                $feild_sql      = new SQLDatabase;

                //2. ĐIỀU KIỆN CẬP NHẬT
                $update_condition = [];
                if($themes != '') {
                    $update_condition[] = ['themes', $themes];
                }
                if($pages != '') {
                    $update_condition[] = ['pages', $pages];
                }

                //3. DỮ LIỆU CẬP NHẬT
                //($feilds_data: Đã xử lý ở trên)
                
                //4. CẬP NHẬT
                $update_data = $feild_sql->update_or_create($feilds_data, $update_condition);

                if($update_data) {

                    //clear cache
                    GlobalController::clearCache('fillable');

                    //THÊM FILLABLE
                    $fillable_table = self::setFillable($fillable_column, $fillable_type);
                    self::updateFillable([
                        'table_name'        => $pages, 
                        'table_fillable'    => GlobalController::parse_json($fillable_table)
                    ], ['table_name' => $pages]);

                    //1. SET TABLE - OPEN CLASS
                    GlobalController::set_table($this->tb_detail);
                    GlobalController::set_fillable($fillable_detail);
                    $feild_detail_sql   = new Field_detail;
                    $feild_group_sql    = new SQLGroupDatabase;
                    

                    //2. ĐIỀU KIỆN CẬP NHẬT
                    //(Chi tiết: Hàm chỉ tạo nên không cần điều kiện)

                    //3. DỮ LIỆU CẬP NHẬT
                    //($feilds_detail: Đã xử lý ở trên)

                    //3.1. XÓA CHI TIẾT
                    // $feild_detail_sql->remove_data($update_condition);

                    //4. CẬP NHẬT
                    foreach ($feilds_detail as $keys => $detail_items) {

                        $detail_condition   = $detail_items['condition'];
                        $detail_data        = $detail_items['data'];

                        $add_detail = $feild_detail_sql->update_or_create($detail_data, $detail_condition);

                        if($add_detail) {

                            if(isset($detail_condition[0][1]) && $detail_condition[0][1] != '') {
                                $newDetailId    = $detail_condition[0][1];
                            } else {
                                $newDetailId    = $feild_detail_sql->get_max_id();
                            }

                            //Set new ID 
                            self::set_value($newDetailId);

                            //Xóa group detail
                            $feild_group_sql->remove_data(['fdetail_id' => $newDetailId]);
                            
                            foreach ($form_detail[$keys]->groups as $key=>$d_items) {
                                $group_groups = [];
                                $group_groups['fdetail_id'] = self::get_value();
                                foreach ($d_items as $gd_items) {
                                    foreach ($gd_items as $k=>$gdd_items) {
                                        $key_name                       = $k;
                                        $group_groups[$key_name] = $gdd_items;
                                    }
                                }
                                $feild_group_sql->create_data($group_groups);
                            }

                        }

                    }

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


    /**
     * THÊM FILLABLE CHO TỪNG MODULES
     */
    public static function updateFillable($data, $condition='') {

        $status = GlobalController::$warning;

        GlobalController::set_table('fillable');
        GlobalController::set_fillable(['table_name', 'table_fillable']);
        $sql    = new SQLDatabase;

        $update = $sql->update_or_create($data, $condition);

        if($update) {
            $status = GlobalController::$success;
        }

        return $status;

    }


}
