<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Facades\App\Repository\Translation;

use App\Http\Controllers\GlobalController;

class TranslationController extends Controller
{
    
    //GET KEY
    public static function translation($languageKey, $language='') {

        $translate_data = Translation::all();

        $languageActived = $language != '' ? $language : GlobalController::get_language();

        if(isset($translate_data[$languageActived][$languageKey])) {
            $translateName = $translate_data[$languageActived][$languageKey];
        } else {
            $translateName  = 'Không tồn tại mã sử dụng để dịch';
        }

        return $translateName;

    }


}
