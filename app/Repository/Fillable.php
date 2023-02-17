<?php

namespace App\Repository;

use App\Http\Controllers\GlobalController;
use App\SQLDatabase;

use Carbon\Carbon;

class Fillable {

    public function all() {

        GlobalController::set_table(GlobalController::$table_fillable); //fillable
        $sql    = new SQLDatabase;

        $cacheKey   = GlobalController::getCacheKey(GlobalController::$table_fillable);

        //Time cache
        $time_cache = GlobalController::getCacheTimeKey(GlobalController::$table_fillable);

        $data       = [];

        $get_data   = $sql->get_data('get');

        if($get_data) {

            foreach ($get_data as $items) {

                $key    = $items->table_name;
                $value  = $items->table_fillable;

                $data[$key] = $value;

            }

        }

        // remove cache
        cache()->forget($cacheKey);

        return cache()->remember($cacheKey, Carbon::now()->addMinutes($time_cache), function() use ($data) {
            return $data;
        });

    }

}