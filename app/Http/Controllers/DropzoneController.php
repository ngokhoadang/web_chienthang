<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\GlobalController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TranslationController;

use App\SQLDatabase;

use Config, File;

class DropzoneController extends Controller
{

    //Load file
    public function loadFolder(Request $request, $folder_id) {

        $permission = PermissionController::getAuth('media');

        $status     = GlobalController::$warning;
        $alert      = Config::get('constants.alert.not_update');
        $message    = [];

        $folderData = [];
        $fileData   = [];

        if(in_array(GlobalController::$permissionView, $permission)) {

            //open model
            GlobalController::set_table(GlobalController::$table_media);
            $sql = new SQLDatabase;

            $get_data   = $sql->get_data('get', ['folder_id' => $folder_id]);
            if($get_data) {

                foreach ($get_data as $items) {

                    $dataArray  = [
                        'id'        => $items->id,
                        'folder_id' => $items->folder_id,
                        'name'      => $items->file_name,
                        'path'      => $items->file_path,
                        'thumbs'    => $items->file_thumbs,
                        'type'      => $items->file_type,
                        'icon'      => $items->file_icon,
                        'alt'       => $items->file_alt
                    ];

                    if($items->file_type == 'folder') {
                        $folderData[]   = $dataArray;
                    } else {
                        $fileData[]     = $dataArray;
                    }

                    $status = GlobalController::$success;
                    $alert  = Config::get('constants.modules.loaded');

                }

            }
            
        } else {
            $message[]    = Config::get('constants.alert.permission_denied');
        }

        $data   = [
            'folder'    => $folderData,
            'file'      => $fileData
        ];

        return response()->json([
            'status'    => $status,
            'alert'     => $alert,
            'message'   => $message,
            'data'      => $data
        ]);

    }

    public function postFolder(Request $request) {

        $permission = PermissionController::getAuth('media');

        $status     = GlobalController::$warning;
        $alert      = Config::get('constants.alert.not_update');
        $message    = [];

        $createFolder   = false;

        if(!in_array(GlobalController::$permissionUpdate, $permission)) {
            $message[]    = Config::get('constants.alert.permission_denied');
        }

        if($request->ajax()) {

            $folderID      = intval($request->folder_id);
            $folderName    = GlobalController::stripTags($request->folder_name);

            //Kiểm tra điều kiện
            if($folderName == '') {
                $message[]  = Config::get('constants.alert.folder_empty');
            }

            if(empty($message)) {

                //open class
                GlobalController::set_fillable(GlobalController::$mediaFillable);
                GlobalController::set_table(GlobalController::$table_media);
                $sql    = new SQLDatabase;

                $condition  = [
                    ['id' => $folderID]
                ];

                //Convert str to en
                $folderPathName = GlobalController::convertViToEn($folderName, '_');
                $folderPathName .= '/';

                //path: 'public/uploads/folder_name: insert to database
                $getFolderPath  = GlobalController::$public_path.GlobalController::$uploads_path;
                if($folderID > 0) {
                    $get_folder = $sql->get_data('first', ['id'=>$folderID]);
                    $getFolderPath  = (isset($get_folder->file_path) && $get_folder->file_path != '') ? $get_folder->file_path : $getFolderPath;
                }
                $pathUpload         = $getFolderPath.$folderPathName;

                
                $createFolderPath   = public_path(str_replace(GlobalController::$public_path, '', $pathUpload));
                if(!File::exists($createFolderPath)) {
                    $createFolder = File::makeDirectory($createFolderPath, $mode = 0777, true, true);
                } else {
                    $message[]      = Config::get('constants.alert.file_exists');
                }

                if($createFolder) {

                    $update = $sql->update_or_create([
                        'folder_id' => $folderID,
                        'file_name' => $folderName,
                        'file_path' => $pathUpload,
                        'file_type' => 'folder',
                        'file_icon' => '<i class="fa fa-folder" aria-hidden="true"></i>'
                    ], ['id' => NULL]);

                    if($update) {
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
    
    public function postUpload(Request $request) {

        $status     = GlobalController::$warning;
        $alert      = Config::get('constants.alert.not_update');
        $message    = [];

        $imagePath  = '';
        $imageName  = '';

        if($request->ajax()) {
            
            $folder_id  = intval($request->folder_id);
            $file       = $request->file;            

            GlobalController::set_fillable(GlobalController::$mediaFillable);
            GlobalController::set_table(GlobalController::$table_media);
            $sql    = new SQLDatabase;

            $update = GlobalController::uploadImages($request, $folder_id, [
                ['file']
            ], $sql, ['id' => NULL]);

            // $message += isset($update['message']) ? $update['message'] : [];

            if(isset($update['status']) && $update['status'] == 'success') {

                $imagePath   = isset($update['imagePath']) ? $update['imagePath'] : '';
                $imageName   = isset($update['imageName']) ? $update['imageName'] : '';

                $status     = GlobalController::$success;
                $alert      = Config::get('constants.alert.not_update');
            }

        }

        return response()->json([
            'status'    => $status,
            'alert'     => TranslationController::translation($alert),
            'message'   => $message,
            'imagePath' => $imagePath,
            'imageName' => $imageName,
        ]);

    }

}
