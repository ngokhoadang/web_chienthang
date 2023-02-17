<?php

namespace App\Repository;

use App\Http\Controllers\GlobalController;

use Carbon\Carbon;

class frontendBannerSlide {

    private static $cache_key;

    /**
     * LOAD PERMISSION
     */
    public function all() {

        $cache_key  = GlobalController::$CACHE_FRONTEND_SLIDE;

        $cacheKey   = GlobalController::getCacheKey($cache_key);

        //Time cache
        $time_cache = GlobalController::getCacheTimeKey($cache_key);

        $data       = GlobalController::loadListDataSQL([
            ['banner_status', 1]
        ], GlobalController::$table_banners, GlobalController::$bannerSlideFillable);

        if(!empty($data)) {
            $status = GlobalController::$success;
        }

        //Xóa cache
        cache()->forget($cacheKey);

        return cache()->remember($cacheKey, Carbon::now()->addMinutes($time_cache), function() use ($data){
            return $data;
        });

    }

}