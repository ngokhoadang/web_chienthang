<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Http\Controllers\GlobalController;

use App\User;
use App\SQLDatabase;

use Config, Hash;

class UserController extends Controller
{
    
    protected $user;

    public function __construct(User $users) {
        $this->user = $users;
    }

    public function getUpdate($id) {

        $titlePage  = 'CẬP NHẬT THÀNH VIÊN';

        $fetchData = [];

        $get_data = $this->user->get_data('first', ['id' => $id]);
        if($get_data) {

            $group_id   = $get_data->group_id;

            $fetchData   = [
                'id'        => $id,
                'name'      => $get_data->name,
                'fullname'  => $get_data->full_name,
                'email'     => $get_data->email,
                'phone'     => $get_data->phone,
                'sex'       => $get_data->sex,
                'status'    => $get_data->status,
                'avatar'    => $get_data->avatar
            ];
            
        }

        //Selected group
        $selectedGroup = GlobalController::selected_group($group_id);

        $data = [
            'data'              => $fetchData,
            'group_selected'    => $group_id,
            'group_initial'     => $selectedGroup['initial']
        ];
        

        $web_action = GlobalController::get_web_action('users', GlobalController::$update);

        //themes
        $themes     = GlobalController::get_themes();

        $view       = GlobalController::get_view('users', 'form');

        return view($view, compact('web_action', 'themes', 'data', 'titlePage'));

    }

    public function postCreate(Request $request) {

        $status     = GlobalController::$warning;
        $alert      = Config::get('constants.alert.not_update');
        $message    = [];

        if($request->ajax()) {

            $type       = $request->type; //create or update
            $user_id    = isset($request->user_id) ? $request->user_id : '';
            $group_id   = intval($request->group_id);
            $username   = GlobalController::stripTags($request->username);
            $password   = GlobalController::stripTags($request->password);
            $api_token  = Str::random(60);
            $fullname   = GlobalController::stripTags($request->fullname);
            $email      = GlobalController::stripTags($request->email);
            $phone      = GlobalController::stripTags($request->phone);
            $sex        = $request->sex;
            $oldImage   = $request->oldImage;
            $user_status= $request->status;

            $condition  = [['id', $user_id]];
            $user_update = [
                'group_id'  => $group_id, 
                'name'      => $username, 
                'email'     => $email, 
                'api_token' => $api_token, 
                'phone'     => $phone, 
                'full_name' => $fullname, 
                'sex'       => $sex, 
                'status'    => $user_status
            ];

            //Xử lý mật khẩu
            $whereDuplicateCondition    = ''; //Nếu là thêm mới thì chỉ cần kiểm tra username hoặc email
            $orWhereDuplicateCondition  = '';
            switch ($type) {
                case 'create':
                    if($password != '') {
                        if(strlen($password) > GlobalController::$minPassword) {
                            $user_password  = Hash::make($password);
                            $user_update    += ['password'  => $user_password]; //Thêm password
                        } else {
                            $message[]  = Config::get('constants.alert.password_short');
                        }
                    } else {
                        $message[]  = Config::get('constants.alert.password_empty');
                    }
                    $whereDuplicateCondition    = [['name', $username]]; //Nếu là thêm mới thì chỉ cần kiểm tra username hoặc email
                    $orWhereDuplicateCondition  = [['email', $email]];
                    break;
                case 'update':
                    if($password != '') {
                        $user_password  = Hash::make($password);
                        $user_update    += ['password'  => $user_password]; //Cập nhật password
                    }
                    $whereDuplicateCondition    = [['id', '<>', $user_id], ['name', $username]]; //Nếu là thêm mới thì chỉ cần kiểm tra username hoặc email
                    $orWhereDuplicateCondition  = [['id', '<>', $user_id], ['email', $email]];
                    break;
                default:
                    $message[]  = Config::get('constants.alert.request_block'); //Yêu cầu không được cấp phát
                    break;
            }

            if(empty($condition)) {
                $message[]  = Config::get('constants.alert.not_condition');
            }

            if(empty($message)) {

                $duplicate  = $this->user->check_duplicate([
                    'where'     => $whereDuplicateCondition,
                    'orWhere'   => $orWhereDuplicateCondition
                ]);
                if($duplicate) {
                    $message[]    = Config::get('constants.alert.user_duplicated');
                }

                if($duplicate == false) {

                    $update = $this->user->update_or_create($user_update, $condition);

                    if($update) {
                        //Update image
                        $new_id     = intval($user_id) > 0 ? $user_id : $this->user->get_max_id();
                        $path       = 'public/uploads/avatar';
                        $post_image = GlobalController::postImage($path, $request, $this->user, [
                            ['avatar', 'images', ['jpg', 'png']]
                        ], ['id' => $new_id], [$oldImage]);

                        //Xử lý quyền truy cập
                        $permissions = json_decode($request->permissions);

                        if (!empty($permissions)) {

                            GlobalController::set_fillable(GlobalController::$permissionDetailFillable);
                            GlobalController::set_table('permission_details');
                            $userPermission = new SQLDatabase;

                            //CẬP NHẬT TẤT CẢ CÁC QUYỀN VỀ TRẠNG THÁI 0
                            $userPermission->update_data([
                                'perdetail_status'      => 0
                            ], ['user_id' => $new_id]);

                            foreach ($permissions as $permissionItem) {

                                $permissionId       = $permissionItem->id;
                                $permissionModule   = $permissionItem->config;
                                $permission         = $permissionItem->permission;
                                $permissionOder     = $permissionItem->order; //Sắp xếp thứ tự hiển thị trên menu (admin)

                                //CẬP NHẬT CHI TIẾT QUYỀN HẠN
                                $userPermission->update_or_create([
                                    'user_id'               => $new_id,
                                    'perdetail_modules'     => $permissionModule,
                                    'perdetail_permission'  => GlobalController::parse_json($permission),
                                    'perdetail_type'        => 'users',
                                    'perdetail_sort'        => $permissionOder,
                                    'perdetail_status'      => 1
                                ], ['id' => $permissionId]);

                            }
                        }

                        $status = GlobalController::$success;
                        $alert  = Config::get('constants.modules.updated');
                    }

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
