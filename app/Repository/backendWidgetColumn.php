<?php

namespace App\Repository;

use App\Http\Controllers\GlobalController;
use App\SQLDatabase;

use Carbon\Carbon;

class backendWidgetColumn {

    public function all($cache_key='DEFAULT') {

        GlobalController::set_table(GlobalController::$table_widgetColumns);
        $sql    = new SQLDatabase;

        $key        = $cache_key;
        $cacheKey   = GlobalController::getCacheKey($key);

        //Time cache
        $time_cache = GlobalController::getCacheTimeKey('widgetcolumns');

        $data       = [];
        $moduleDetail   = [];

        $get_data   = $sql->get_data('get');

        if($get_data) {

            foreach ($get_data as $items) {

                $data[]    = [
                    'value'  => $items->widget_cols_key,
                    'text' => $items->widget_cols_name
                ];

            }

        }

        // remove cache
        cache()->forget($cacheKey);

        return cache()->remember($cacheKey, Carbon::now()->addMinutes($time_cache), function() use ($data) {
            return $data;
        });

    }

    

}