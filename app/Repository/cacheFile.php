<?php

namespace App\Repository;

use App\Http\Controllers\GlobalController;
use App\SQLDatabase;

use Carbon\Carbon;

class WebConfig {

    public function all() {

        GlobalController::set_table(GlobalController::$table_media); //configs
        $sql    = new SQLDatabase;

        $cacheKey   = GlobalController::getCacheKey(GlobalController::$table_media);

        //Time cache
        $time_cache = GlobalController::getCacheTimeKey(GlobalController::$table_media);

        $data       = [];

        $get_data   = $sql->get_data('get');

        // remove cache
        cache()->forget($cacheKey);

        return cache()->remember($cacheKey, Carbon::now()->addMinutes($time_cache), function() use ($data) {
            return $data;
        });

    }

}