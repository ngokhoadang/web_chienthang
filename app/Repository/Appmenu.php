<?php

namespace App\Repository;

use App\Http\Controllers\GlobalController;
use App\Http\Controllers\PermissionController;

use App\SQLDatabase;

use Session, Auth;
use Carbon\Carbon;

class Appmenu {

    private static $cache_key;
    private static $pt_key;
    private static $user_id = 1;

    //pt: phân trang
    public function set_pt($pt) {
        static::$pt_key = $pt;
    }

    public function get_pt(){
        return static::$pt_key;
    }

    /**
     * MENU ACTIVE
     */
    public function menu_active($key) {
        $li_active = '';
        $module = $this->get_pt();
        if(isset($key) && $key == $module) {
            $li_active = 'active';
        }
        return $li_active;
    }

    /**
     * CACHE: TẤT CẢ DS CÁC PERMISSION ĐÃ GÁN GIÁ TRỊ
     * -- Để lấy ds ko lấy lại ở ds hiển thị sắp xếp gom nhóm các permisson group
     */
    public function loadPermissionGroupDetailIDList($condition = '') {

        //OPEN MODEL
        GlobalController::set_table('permissiongroup_details');
        $sql = new SQLDatabase;

        $permissionGroupDetailIDList   = [];

        $get_data   = $sql->get_data('get', $condition);

        if($get_data) {

            foreach ($get_data as $items) {

                $permissionGroupDetailIDList[] = $items->per_group_detail;

            }

        }

        return $permissionGroupDetailIDList;

    }

    /**
     * TẢI DS CÁC DETAIL ADMIN MENU
     * $group_id: Group permission id
     * $permissionList: Permission user
     */
    public function loadPermissionGroupDetail($user_id, $group_id, $userPermission) {

        $menuData   = [];

        //OPEN MODEL
        GlobalController::set_table('permissions');
        $sql = new SQLDatabase;

        $permissionGroupDetailIDList   = $this->loadPermissionGroupDetailIDList(['per_group_id' => $group_id]);

        $get_data   = $sql->get_data('get', [
            'where'     => [
                ['status', 1],
                ['parent_id', 0]
            ],
            'whereIn'   => ['id' => $permissionGroupDetailIDList]
        ]);

        if($get_data) {

            foreach ($get_data as $items) {

                $id         = $items->id;
                $parent_id  = $items->parent_id;

                $perValue   = $items->value;

                if(isset($userPermission[$perValue])) {

                    $menuData[] = [
                        'id'            => $items->id,
                        'icon'          => $items->icon != '' ? $items->icon: '<i class="fa fa-file-o" aria-hidden="true"></i>',
                        'name'          => $items->name,
                        'description'   => $items->description,
                        'value'         => $items->value,
                        'parent_id'     => $items->parent_id,
                        'modules'       => $perValue
                    ];

                }

            }

        }

        return $menuData;

    }

    /**
     * LOAD PERMISSION
     */
    public function loadPermission($user_id) {

        $key = "MENU{$user_id}";
        $cacheKey = GlobalController::getCacheKey('app_menu', $key);

        //Time cache
        $time_cache = GlobalController::getCacheTimeKey('app_menu');
        
        //OPEN CONTROLLER
        $permissionController = new PermissionController;

        //GET LIST PERMISSION USER
        $userPermission = $permissionController->getPermissionUser('users', static::$user_id);

        $menuData   = [];

        //Lấy header permission_group
        GlobalController::set_table('permissiongroups');
        $sql = new SQLDatabase;

        $get_group  = $sql->get_data('get', '', '*', '', 'group_order asc');

        if($get_group) {

            foreach ($get_group as $items) {

                $permission_group_id    = $items->id;
                $permission_group_name  = $items->group_name;

                $menuData[]   = [
                    'header'    => [
                        'id'    => $permission_group_id,
                        'name'  => $permission_group_name
                    ],
                    'list'    => $this->loadPermissionGroupDetail($user_id, $permission_group_id, $userPermission)
                ];

            }

        }

        // cache()->forget($cacheKey);

        return cache()->remember($cacheKey, Carbon::now()->addMinutes($time_cache), function() use ($menuData){
            return $menuData;
        });

    }

    // /**
    //  * LOAD PERMISSION
    //  */
    // public function loadPermission($user_id) {

    //     $key = "MENU{$user_id}";
    //     $cacheKey = GlobalController::getCacheKey($key);

    //     //Time cache
    //     $time_cache = GlobalController::getCacheTimeKey('app_menu');
        
    //     //OPEN CONTROLLER
    //     $permissionController = new PermissionController;

    //     //GET LIST PERMISSION
    //     $dataArray      = $permissionController->getPermissionList(['parent_id'=>0]);

    //     //GET LIST PERMISSION USER
    //     $userPermission = $permissionController->getPermissionUser('users', static::$user_id);

    //     $menuData   = [];

    //     if(!empty($dataArray)) {

    //         foreach ($dataArray as $key=>$items) {
                
    //             $id         = $items['id'];

    //             if($items['parent_id'] == 0) {

    //                 $perValue = $items['value'];

    //                if(isset($userPermission[$perValue])) {

    //                     $menuData[] = [
    //                         'icon'      => $items['icon'],
    //                         'name'      => $items['name'],
    //                         'modules'   => $perValue
    //                     ];

    //                 }

    //                 unset($dataArray[$key]);

    //             }
                
    //         }

    //     }

    //     cache()->forget($cacheKey);

    //     return cache()->remember($cacheKey, Carbon::now()->addMinutes($time_cache), function() use ($menuData){
    //         return $menuData;
    //     });

    // }

    //LOAD ALL MENU
    public function all($user_id) {

        $menu_content   = '';

        $getUrl     = GlobalController::get_url(['admin']);

        $permission = $this->loadPermission($user_id);

        if(!empty($permission)) {

            foreach ($permission as $items) {

                //header
                if(isset($items['header']['name'])) {

                    $menu_content .= '<li class="header">'.$items['header']['name'].'</li>';

                }

                //list menu
                if(isset($items['list']) && !empty($items['list'])) {

                    foreach ($items['list'] as $list_items) {
            
                        $menuUrl    = $getUrl.'/'.$list_items['modules'].'/list';
                        
                        $menu_content .= '<li class="">
                                            <a href="'.$menuUrl.'">
                                                '.$list_items['icon'].'
                                                <span>'.$list_items['name'].'</span>
                                            </a>
                                        </li>';
        
                    }

                }
                
            }

        }

        return $menu_content;

    }

}