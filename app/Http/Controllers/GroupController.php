<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\GlobalController;

use App\SQLDatabase;
use App\Group;

use Config;

class GroupController extends Controller
{
    
    protected $group;

    public function __construct(Group $groups) {
        $this->group = $groups;
    }

    public function postCreate(Request $request) {

        $status     = GlobalController::$warning;
        $alert      = Config::get('constants.alert.not_update');
        $message    = [];

        if($request->ajax()) {

            //Get data
            $group_id       = isset($request->group_id) ? $request->group_id : '';
            $group_name     = GlobalController::stripTags($request->group_name);
            $group_intro    = GlobalController::stripTags($request->group_intro);

            //Điều kiện cập nhật
            $updateCondition    = [['id', $group_id]];

            if(strlen($group_name) < 3) {
                $message[]  = Config::get('constants.alert.field_short');
            }

            if(empty($message)) {

                GlobalController::set_fillable(['group_name', 'group_intro']);
                GlobalController::set_table('groups');
                $sql = new SQLDatabase;

                $update = $sql->update_or_create([
                    'group_name'    => $group_name,
                    'group_intro'   => $group_intro
                ], $updateCondition);

                if($update) {

                    //Lấy id mới nhất
                    $new_id = $sql->get_max_id();

                    //Xử lý quyền truy cập
                    $permissions = json_decode($request->permissions);

                    if (!empty($permissions)) {

                        GlobalController::set_fillable(GlobalController::$permissionDetailFillable);
                        GlobalController::set_table('permission_details');
                        $userPermission = new SQLDatabase;

                        //CẬP NHẬT TẤT CẢ CÁC QUYỀN VỀ TRẠNG THÁI 0
                        $userPermission->update_data([
                            'perdetail_status'      => 0
                        ], ['group_id' => $new_id]);

                        foreach ($permissions as $permissionItem) {

                            $permissionId       = $permissionItem->id;
                            $permissionModule   = $permissionItem->config;
                            $permission         = $permissionItem->permission;
                            $permissionOder     = $permissionItem->order; //Sắp xếp thứ tự hiển thị trên menu (admin)

                            //CẬP NHẬT CHI TIẾT QUYỀN HẠN
                            $userPermission->update_or_create([
                                'group_id'              => $new_id,
                                'perdetail_modules'     => $permissionModule,
                                'perdetail_permission'  => GlobalController::parse_json($permission),
                                'perdetail_type'        => 'groups',
                                'perdetail_sort'        => $permissionOder,
                                'perdetail_status'      => 1
                            ], ['id' => $permissionId]);

                        }
                    }

                    $status = GlobalController::$success;
                    $alert  = Config::get('constants.modules.updated');

                }

            }

            return response()->json([
                'status'    => $status,
                'alert'     => $alert,
                'message'   => $message
            ]);


        }

    }


}
