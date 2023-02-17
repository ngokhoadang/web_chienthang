<?php

namespace App\Repository;

use App\Http\Controllers\GlobalController;

use Carbon\Carbon;

class loadHeaderFooter {

    public function all($cache_key) {

        $key            = $cache_key;
        $cacheKey       = GlobalController::getCacheKey($key);

        //Time cache
        $time_cache = GlobalController::getCacheTimeKey('header_footer');

        $header         = [];
        $footer         = [];

        $header         = GlobalController::showLayoutData('default', ['header']);
        $footer         = GlobalController::showLayoutData('default', ['footer']);

        $data   = [
            'header'    => $header,
            'footer'    => $footer
        ];

        // remove cache
        cache()->forget($cacheKey);

        return cache()->remember($cacheKey, Carbon::now()->addMinutes($time_cache), function() use ($data) {
            return $data;
        });

    }
    

}