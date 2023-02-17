<?php

namespace App\Repository;

use App\Http\Controllers\GlobalController;
use App\SQLDatabase;

use Carbon\Carbon;

class WebConfig {

    public function all() {

        GlobalController::set_table(GlobalController::$table_webConfig); //configs
        $sql    = new SQLDatabase;

        $cacheKey   = GlobalController::getCacheKey(GlobalController::$table_webConfig);

        //Time cache
        $time_cache = GlobalController::getCacheTimeKey(GlobalController::$table_webConfig);

        $data       = [];

        $get_data   = $sql->get_data('first');

        if($get_data) {

            $data    = [
                'name'          => $get_data->web_name,
                'url'           => $get_data->web_url,
                'folder'        => $get_data->web_folder,
                'logo'          => $get_data->web_logo,
                'hotline'       => $get_data->web_hotline,
                'keyword'       => $get_data->web_keyword,
                'description'   => $get_data->web_description,
                'contact'       => $get_data->web_contact,
                'info'          => $get_data->web_info,
                'copyright'     => $get_data->web_copyright,
                'language'      => $get_data->language
            ];

        }

        //
        GlobalController::set_table(GlobalController::$table_webThemes); //configs
        $themes     = new SQLDatabase;
        $get_themes = $themes->get_data('first', ['enable' => 1]);
        if($get_themes) {
            $data += ['themes' => isset($get_themes->folder) ? $get_themes->folder : GlobalController::$defaultThemes];
        }

        // remove cache
        // cache()->forget($cacheKey);

        return cache()->remember($cacheKey, Carbon::now()->addMinutes($time_cache), function() use ($data) {
            return $data;
        });

    }

}