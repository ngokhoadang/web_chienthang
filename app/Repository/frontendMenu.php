<?php

namespace App\Repository;

use App\Http\Controllers\GlobalController;

use App\SQLDatabase;

use Carbon\Carbon;

class frontendMenu {

    private static $cache_key;
    private static $pt_key;

    //pt: phân trang
    public function set_pt($pt) {
        static::$pt_key = $pt;
    }

    public function get_pt(){
        return static::$pt_key;
    }

    /**
     * MENU ACTIVE
     */
    public function menu_active($key) {
        $li_active = '';
        $module = $this->get_pt();
        if(isset($key) && $key == $module) {
            $li_active = 'active';
        }
        return $li_active;
    }

    /**
     * LOAD PERMISSION
     */
    public function getMenuList() {

        $cache_key  = GlobalController::$CACHE_FRONTEND_MENU;

        $cacheKey   = GlobalController::getCacheKey($cache_key);

        //Time cache
        $time_cache = GlobalController::getCacheTimeKey($cache_key);

        $menuArray   = [];

        GlobalController::set_table(GlobalController::$table_category);
        $sql        = new SQLDatabase;

        $get_data   = $sql->get_data('get', ['cate_status' => 1]);

        $menuArray  = [];

        $rootUrl     = GlobalController::get_url();

        if($get_data) {

            foreach ($get_data as $items) {

                $cate_id        = $items->id;
                $modules        = $items->cate_modules;

                //Count sub
                $count_sub   = $sql->get_data('count', ['category' => $cate_id]);

                $menuArray[$modules][]    = [
                    'id'            => $items->id,
                    'pages'         => $items->pages,
                    'parent_id'     => $items->category,
                    'title'         => $items->cate_title,
                    'alias'         => $items->cate_alias,
                    'url'           => $items->cate_url,
                    'url_extend'    => $items->cate_url_extent,
                    'modules'       => $modules,
                    'type'          => $items->cate_mainmenu,
                    'count_sub'     => $count_sub
                ];

            }

        }

        cache()->forget($cacheKey);

        return cache()->remember($cacheKey, Carbon::now()->addMinutes($time_cache), function() use ($menuArray){
            return $menuArray;
        });

    }

    //LOAD ALL MENU
    //$type_menu: mainmenu, submenu
    public function all($parent_id=0) {

        $menuData   = $this->getMenuList();

        $menu       = $this->showMenu($menuData, $parent_id);

        return $menu;

    }

    public function showMenu($data, $parent_id=0, $module='contents') {

        $menuHTML   = '<ul class="menu">';

        if(isset($data[$module]) && !empty($data[$module])) {

            foreach ($data[$module] as $key=>$items) {

                $id         = $items['id'];

                $link    = GlobalController::urlAlias($items['url'], $items['alias'], $items['url_extend']);

                if($items['parent_id'] == $parent_id) {

                    $menuHTML .= '<li>';

                    if(isset($items['count_sub']) && $items['count_sub'] > 0) {

                        $menuHTML .= '<a href="'.$link.'">'.$items['title'].'</a>';
                        $menuHTML .= $this->showMenu($data, $id, $module);

                    } else {
                        $menuHTML .= '<a href="'.$link.'">'.$items['title'].'</a>';
                    }

                    $menuHTML .= '</li>';

                    unset($data[$module][$key]);

                }

            }

        }

        $menuHTML   .= '</ul>';

        return $menuHTML;

    }

    /**
     * SHOW MENU TO BROWSER
     */
    public function menuArray($data, $parent_id=0, $module='contents') {

        $menuData   = [];

        if(isset($data[$module]) && !empty($data[$module])) {

            foreach ($data[$module] as $key=>$items) {

                $id     = $items['id'];

                if($items['parent_id'] == $parent_id) {

                    $menuData[] = [

                        'title' => $items['title']

                    ];

                    unset($data[$module][$key]);


                    if(isset($items['count_sub']) && $items['count_sub'] > 0) {

                        $menuData[$key] += $this->showMenu($data, $id, $module);

                    }

                }

            }

        }

        return $menuData;

    }

}