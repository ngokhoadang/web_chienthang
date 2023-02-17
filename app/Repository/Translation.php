<?php

namespace App\Repository;

use App\Http\Controllers\GlobalController;
use App\SQLDatabase;

use Carbon\Carbon;

class Translation {

    public function all() {

        GlobalController::set_table(GlobalController::$table_translation); //translation
        $sql    = new SQLDatabase;

        $cacheKey   = GlobalController::getCacheKey(GlobalController::$table_translation);

        //Time cache
        $time_cache = GlobalController::getCacheTimeKey(GlobalController::$table_translation);

        $data       = [];

        $get_data   = $sql->get_data('get');

        if($get_data) {
            $data   = $this->revertTranslation($get_data);
        }

        // remove cache
        cache()->forget($cacheKey);

        return cache()->remember($cacheKey, Carbon::now()->addMinutes($time_cache), function() use ($data) {
            return $data;
        });

    }

    //SORT DATA
    public function revertTranslation($data) {

        $revertData = [];

        if(!empty($data)) {

            foreach ($data as $items) {

                $language   = $items->translate_language;
                $key        = $items->language_key; //Key get
                $name       = $items->translate_name; //Title show in browser

                if($language != '') {
                    
                    $revertData[$language][$key]  = $name;

                }

            }

        }

        return $revertData;

    }

}