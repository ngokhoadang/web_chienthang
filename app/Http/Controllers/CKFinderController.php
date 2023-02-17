<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class CKFinderController extends Controller
{
    
    public function ckconnector() {
		
		$ckfinder_auth = true;
		
		//Kiểm tra quyền
        // $permission     = PermissionController::getAuth('widget');
        // if(in_array('add',$permission,true) OR in_array('edit',$permission,true)) {
		// 	$ckfinder_auth = true;
		// }
		
		define('CKFINDER_ACCESS', $ckfinder_auth); //admin\plugins\editor
		
		require_once public_path("templates/mtThemes/admin/plugins/editor/ckfinder/core/connector/php/connector.php");
	}
	
    public function loadckfinder () {

        $themes = GlobalController::get_themes();

		return view('templates.'.$themes.'.admin.plugins.ckfinder');
	}

}
