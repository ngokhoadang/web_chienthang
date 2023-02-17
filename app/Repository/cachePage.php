<?php

namespace App\Repository;

use App\Http\Controllers\GlobalController;
use App\SQLDatabase;

use Carbon\Carbon;

class cachePage {

    public function all() {

        GlobalController::set_table(GlobalController::$table_pages);
        $sql    = new SQLDatabase;

        $cacheKey   = GlobalController::getCacheKey(GlobalController::$table_pages);

        //Time cache
        $time_cache = GlobalController::getCacheTimeKey(GlobalController::$table_pages);

        $data['id']       = [];
        $data['key']       = [];

        $get_data   = $sql->get_data('get');

        if($get_data) {

            foreach ($get_data as $items) {

                //Get pages by id
                if(isset($data['id'][$items->id])) {
                    $data['id'][$items->id]   += [
                        'id'        => $items->id,
                        'module'    => $items->page_modules,
                        'name'      => $items->page_title
                    ];
                } else {
                    $data['id'][$items->id]   = [
                        'id'        => $items->id,
                        'module'    => $items->page_modules,
                        'name'      => $items->page_title
                    ];
                }

                //Get pages by key
                if(isset($data['key'][$items->id])) {
                    $data['id'][$items->id]   += [
                        'id'        => $items->id,
                        'module'    => $items->page_modules,
                        'name'      => $items->page_title
                    ];
                } else {
                    $data['key'][$items->id]   = [
                        'id'        => $items->id,
                        'module'    => $items->page_modules,
                        'name'      => $items->page_title
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