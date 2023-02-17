<?php

namespace App\Repository;

use App\Http\Controllers\GlobalController;
use App\SQLDatabase;

use Carbon\Carbon;

class cacheLayout {

    public function all() {

        GlobalController::set_table(GlobalController::$table_layout);
        $sql    = new SQLDatabase;

        $cacheKey   = GlobalController::getCacheKey(GlobalController::$table_layout);

        //Time cache
        $time_cache = GlobalController::getCacheTimeKey(GlobalController::$table_layout);

        $data       = [];

        $get_data   = $sql->get_data('get');

        if($get_data) {

            foreach ($get_data as $items) {

                //Get pages by id
                if(isset($data[$items->id])) {
                    $data[$items->id]   += [
                        'id'        => $items->id,
                        'themes'    => $items->themes,
                        'pages'      => $items->pages,
                        'name'      => $items->name
                    ];
                } else {
                    $data[$items->id]   = [
                        'id'        => $items->id,
                        'themes'    => $items->themes,
                        'pages'     => $items->pages,
                        'name'      => $items->name
                    ];
                }

            }

        }

        // remove cache
        cache()->forget($cacheKey);

        return cache()->remember($cacheKey, Carbon::now()->addMinutes($time_cache), function() use ($data) {
            return $data;
        });

    }

}