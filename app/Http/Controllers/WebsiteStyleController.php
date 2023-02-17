<?php

namespace App\Http\Controllers;

use App\Http\Controllers\GlobalController;

use Illuminate\Http\Request;

use App\SQLDatabase;

use File, Auth, Config;

class WebsiteStyleController extends Controller
{
    
    //Get create
    public function getConfig($module='webstyles') {
        
        $titlePage      = 'TẢI LÊN '.$module;

        //Themes
        $themes         = GlobalController::get_themes();

        $web_action     = GlobalController::get_web_action($module, GlobalController::$create);

        //CHECK AUTH
        $permission     = PermissionController::getAuth($module);

        $data           = [];
        $header_buttons = [];

        if(in_array(GlobalController::$permissionConfig, $permission)) {

            //Lấy ds các file cho phép thành viên đã đăng nhập cập nhật vào
            $AuthName     = Auth::user()->name;
            GlobalController::set_table($module);
            $sql            = new SQLDatabase;

            $get_data       = $sql->get_data('get', ['style_status' => 1, 'style_author' => $AuthName]);
            if($get_data) {
                foreach ($get_data as $items) {

                    $data[] = [
                        'style_name'    =>  $items->style_name,
                        'style_note'    =>  $items->style_note,
                        'style_file'    =>  $items->style_file,
                        'style_access'    =>  $items->style_access,
                        'style_created'    =>  $items->style_created,
                        'style_author'    =>  $items->style_author,
                        'style_status'    =>  $items->style_status,
                    ];

                }
            }

            $header_buttons[] = GlobalController::admin_button_header($module, GlobalController::$create);

            //Button view
            if(in_array(GlobalController::$permissionView, $permission)) {
                $header_buttons[] = GlobalController::admin_button_header($module, GlobalController::$list);
            }

            $moduleView = 'webstyles_config';
            $pageView   = 'config';

        } else {
            $moduleView = 'errors';
            $pageView   = '403';
        }

        $view       = GlobalController::get_view($moduleView, $pageView);

        return view($view, compact('web_action', 'header_buttons', 'themes', 'module', 'titlePage', 'data'));

    }

    /**
     * THỰC HIỆN UPDATE FILE STYLE
     */
    public function postStyles(Request $request) {

        $status         = GlobalController::$warning;
        $alert          = Config::get('constants.alert.not_update');

        $message    = [];
        $data       = [];

        $extAllowPost   = ['css'];

        $autoPath   = 'public/templates/'.GlobalController::get_themes().'/styles';

        GlobalController::set_table(GlobalController::$table_webstyles);
        $sql = new SQLDatabase;

        if($request->ajax()) {

            $styleID    = $request->id;

            if($request->has('file')) {

                $fileImg    = $request->file('file');
                $file_name  = $fileImg->getClientOriginalName();
                $ext        = $fileImg->getClientOriginalExtension();
                $fileName   = GlobalController::changeFileName($file_name,$ext,'author', Auth::user()->name);

                $path       = public_path(str_replace(GlobalController::$public_path, '', $autoPath)).'/';

                if(in_array($ext, $extAllowPost, true)) {

                    $fileURLUpload  = $autoPath.'/'.$fileName;

                    $update     = $sql->update_data([
                        'style_file'    => $fileURLUpload
                    ], ['id' => $styleID]);

                    if($update) {
                        
                        $fileImg->move($path, $fileName);

                        $status = GlobalController::$success;
                        $alert  = Config::get('constants.alert.updated');

                    }

                } else {

                    $alert  = Config::get('constants.alert.file_denied'); //Định dạng không cho phép upload

                }

            } else {

                $alert  = Config::get('constants.alert.file_empty'); //Không tồn tại file để upload

            }

        }

        return [
            'status'    => $status,
            'alert'     => TranslationController::translation($alert),
            'message'   => $message
        ];

    }

}
