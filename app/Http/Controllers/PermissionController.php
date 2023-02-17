<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\GlobalController;
use App\Http\Controllers\TranslationController;

use Facades\App\Repository\Appmenu;

use App\SQLDatabase;

use Config, Auth;

class PermissionController extends Controller
{

    public static $table        = 'permissions';
    public static $table_detail = 'permission_details';
    public static $table_group_detail = 'permissiongroup_details';

    /**
     * GET PERMISSION LIST
     * Get all permission from database
     */
    public function getPermissionList($condition='') {

        $data   = [];

        GlobalController::set_table(static::$table);
        $sql = new SQLDatabase;

        if($condition == '') {
            $condition  = ['status' => 1];
        }

        $get_data   = $sql->get_data('get', $condition);
        if($get_data) {
            foreach ($get_data as $items) {
                $data[] = [
                    'id'            => $items->id,
                    'icon'          => $items->icon != '' ? $items->icon: '<i class="fa fa-file-o" aria-hidden="true"></i>',
                    'name'          => $items->name,
                    'description'   => $items->description,
                    'value'         => $items->value,
                    'parent_id'     => $items->parent_id
                ];
            }
        }

        return $data;

    }

    /**
     * GET PERMISSION USER
     * $type: users or groups
     * $loadID: user_id, group_id
     */
    public function getPermissionUser($type, $loadID) {

        $permissionData         = [];
        $permissionCondition    = [];
        if($type != '' && $loadID != '') {
            $permissionCondition = [
                ['perdetail_status', 1],
                ['perdetail_type', $type],
                ['user_id', $loadID]
            ];
        }
        
        if(!empty($permissionCondition)) {
            GlobalController::set_table(static::$table_detail);
            $permissionSQL = new SQLDatabase;
            $getPermission   = $permissionSQL->get_data('get', $permissionCondition);
            if($getPermission) {
                foreach($getPermission as $perItems) {
                    $permissionData[$perItems->perdetail_modules]   = [
                        'id'            => $perItems->id,
                        'modules'       => $perItems->perdetail_modules,
                        'permission'    => $perItems->perdetail_permission,
                        'order'         => $perItems->perdetail_sort
                    ];
                }
            }
        }

        return $permissionData;

    }
    
    //GET LIST
    public function getPermission() {

        
        $dataArray  = $this->getPermissionList();

        $data       = $this->getPermissionLevel($dataArray, 0);

        //Lấy permission của users || NẾU tồn tại type, loadid
        $type   = (isset($_GET['type']) && $_GET['type'] != '') ? $_GET['type'] : '';
        $loadid = (isset($_GET['loadid']) && $_GET['loadid'] != '') ? $_GET['loadid'] : '';        
        
        $permissionData = $this->getPermissionUser($type, $loadid);        

        return response()->json([
            'status'    => 'success',
            'data'      => $data,
            'permission'=> $permissionData
        ], 200);

    }


    //GET PERMISSION LEVEL
    public function getPermissionLevel($get_data, $parent_id=0) {

        $data    = [];

        if(!empty($get_data)) {

            foreach ($get_data as $key=>$items) {
                
                $id     = $items['id'];

                $permission_data    = [];
                $permission_detail  = [];

                if($items['parent_id'] == $parent_id) {
                    $permission_data = [
                        'id'            => $id,
                        'name'          => $items['name'],
                        'description'   => $items['description'],
                        'value'         => $items['value'],
                        'parent_id'     => $items['parent_id']
                    ];
                    unset($get_data[$key]);
                }                

                if(!empty($get_data)) {

                    foreach ($get_data as $dKey=>$detail_items) {
                
                        $detailId     = $detail_items['id'];
        
                        if($detail_items['parent_id'] == $id) {
                            $permission_detail[] = [
                                'id'            => $detailId,
                                'name'          => $detail_items['name'],
                                'description'   => $detail_items['description'],
                                'value'         => $detail_items['value'],
                                'parent_id'     => $detail_items['parent_id']
                            ];
                            unset($get_data[$dKey]);
                        }
                    }
                }

                if(!empty($permission_data)) {

                    $data[] = [
                        'data'      => $permission_data,
                        'detail'    => $permission_detail
                    ];

                }
                
            }

        }

        return $data;

    }

    /**
     * GET AUTH
     * Lấy các quyền theo từng modules
     */
    public static function getAuth($modules='') {

        GlobalController::set_table(static::$table_detail);
        $sql = new SQLDatabase;

		$data = [];

		//Kiểm tra đăng nhập
		if($modules != '' && Auth::check()) {

            $permissionCondition   = [
                ['user_id', Auth::id()],
                ['perdetail_modules', $modules],
                ['perdetail_status', 1]
            ];

			$get_permission = $sql->get_data('first', $permissionCondition);

			if($get_permission) {

				$data = json_decode($get_permission->perdetail_permission);

			}

		}

		return $data;

    }

    /**
     * CONFIG PERMISSION GROUPS
     * SẮP XẾP QUYỀN HẠN THEO TỪNG NHÓM
     */
    //VIEW UPDATE
    public function configPermission() {

        $titlePage  = 'PHÂN NHÓM QUYỀN HẠN';

        $web_action = GlobalController::get_web_action('permissiongroups', 'configs');

        //themes
        $themes     = GlobalController::get_themes();

        $view       = GlobalController::get_view('permissiongroups', 'config');

        return view($view, compact('web_action', 'themes', 'titlePage'));

    }

    //Tải chi tiết permission_group
    public function getPermissionGroupDetail($group_id) {

        GlobalController::set_table(static::$table_group_detail);
        $sql    = new SQLDatabase;

        $data   = [];

        $get_data = $sql->get_data('get', ['per_group_id' => $group_id]);

        if($get_data) {

            foreach ($get_data as $items) {

                $data[] = [
                    'id'    => $items->per_group_detail,
                    'name'  => $items->per_group_detail_name
                ];

            }

        }

        return $data;
        
    }


    /**
     * TẢI DS CÁC GROUP PERMISISON GROUPS
     */
    public function jsonPermissionGroup(Request $request) {

        $status = GlobalController::$warning;

        $data   = [];

        if($request->ajax()) {

            $get    = json_decode($request->get);
            $pages  = GlobalController::form_get_process($get, 'pages');

            GlobalController::set_table($pages);
            $sql    = new SQLDatabase;

            $get_data = $sql->get_data('get', '', '*', '', 'group_order asc');

            if($get_data) {

                foreach ($get_data as $items) {

                    $permission_group_id    = $items->id;

                    $data[] = [
                        'id'    => $permission_group_id,
                        'name'  => $items->group_name,
                        'detail'=> $this->getPermissionGroupDetail($permission_group_id)
                    ];

                }

            }

            $status = GlobalController::$success;

        }

        return response()->json([
            'status'    => $status,
            'data'      => $data
        ]);

    }

    //Get list permission set to group
    public function permissionList(Request $request) {

        $status = GlobalController::$warning;

        $permissionDetailIDList     = Appmenu::loadPermissionGroupDetailIDList();

        $data   = [];

        if($request->ajax()) {

            $permissionList = $this->getPermissionList([
                'whereNotIn'    => ['id' => $permissionDetailIDList]
            ]);

            $permission     = $this->getPermissionLevel($permissionList);

            if(!empty($permission)) {

                foreach ($permission as $pItems) {

                    $data[] = [
                        'id'    => isset($pItems['data']['id']) ? $pItems['data']['id'] : '',
                        'name'  => isset($pItems['data']['name']) ? $pItems['data']['name'] : ''
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
     * CẬP NHẬT PERMISSION GROUP
     */
    public function updatePermissionGroup(Request $request) {

        $message    = [];
        $proccess   = [];

        if($request->ajax()) {

            $permissionGroupData   = json_decode($request->data);

            GlobalController::set_table(static::$table_group_detail);
            GlobalController::set_fillable(GlobalController::$permissionGroupDetailFillable);
            $permissionSQL = new SQLDatabase;

            if(!empty($permissionGroupData)) {

                //Xóa hết các cài đặt cũ
                $permissionSQL->remove_data([]);

                foreach ($permissionGroupData as $items) {

                    $permission_group_id    = $items->group_id;
                    $permission_detail_id   = $items->detail_id;

                    $update = $permissionSQL->update_or_create([
                        'per_group_id'          => $permission_group_id,
                        'per_group_detail'      => $permission_detail_id,
                        'per_group_detail_name' => $items->detail_name
                    ], [
                        'per_group_id'      => $permission_group_id,
                        'per_group_detail'  => $permission_detail_id,
                    ]);

                    if($update) {
                        $proccess[] = 'success';
                    } else {
                        $proccess[] = 'failed';
                    }

                }

            }

            $proccessData  = GlobalController::proccessUpdate($proccess);

            //Xóa cache admin menu
            $cacheKey   = "MENU".Auth::id();
            GlobalController::clearCache('app_menu', $cacheKey);


        }

        return response()->json([
            'status'    => $proccessData['status'],
            'alert'     => TranslationController::translation($proccessData['alert']),
            'message'   => $message
        ]);

    }



}
