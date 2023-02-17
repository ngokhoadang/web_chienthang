<?php

namespace App\Repository;

use App\Http\Controllers\GlobalController;
use App\SQLDatabase;

use Carbon\Carbon;

class cacheFillable {

    public function all($cache_key) {

        GlobalController::set_table(GlobalController::$table_fieldDetail);
        $sql    = new SQLDatabase;

        $key        = $cache_key;
        $cacheKey   = GlobalController::getCacheKey($key);

        //Time cache
        $time_cache = GlobalController::getCacheTimeKey('fillable');

        $fillData       = [];
        $moduleDetail   = [];

        $get_data   = $sql->get_data('get', ['pages' => $cache_key]);

        if($get_data) {

            foreach ($get_data as $items) {

                $fillData[]    = [
                    'name'  => $items->fdetail_name,
                    'label' => $items->fdetail_label
                ];

            }

            //GET DETAIL
            GlobalController::set_table(GlobalController::$table_moduleConfig);
            $sql_detail = new SQLDatabase;

            $get_detail   = $sql_detail->get_data('first', ['pages' => $cache_key]);

            if($get_detail) {

                $module_keys    = json_decode($get_detail->key_modules);

                foreach ($module_keys as $d_items) {

                    $moduleDetail[]   = $d_items->name;

                }

            }

        }

        $data   = [
            'data'      => $fillData,
            'detail'    => $moduleDetail
        ];

        // remove cache
        cache()->forget($cacheKey);

        return cache()->remember($cacheKey, Carbon::now()->addMinutes($time_cache), function() use ($data) {
            return $data;
        });

    }

    

}