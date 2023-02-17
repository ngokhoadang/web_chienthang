<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//CACHE APP MENU
use Facades\App\Repository\WebConfig;

//CACHE LOAD STYLE FOR WEB
use Facades\App\Repository\frontendWebStyles;
use Facades\App\Repository\Fillable;

use App\Http\Controllers\TranslationController;

use App\SQLDatabase;

use Session, Config, File;

class GlobalController extends Controller
{
    
    public static $table;
    public static $fillable;

    public static $minPassword                      = 8; //Số ký tự tối thiểu cho password
    public static $permissionFillable               = ['name', 'parent_id', 'icon', 'description', 'value', 'status'];
    public static $permissionDetailFillable         = ['user_id', 'group_id', 'perdetail_modules', 'perdetail_permission', 'perdetail_type', 'perdetail_sort', 'perdetail_status'];
    public static $permissionGroupDetailFillable    = ['per_group_id', 'per_group_detail', 'per_group_detail_name'];
    public static $moduleConfigFillable             = ['pages', 'name', 'key_modules', 'key_buttons', 'page_length', 'order_by', 'search_box', 'show_paging', 'total_modules', 'fixed_modules', 'module_status'];
    public static $mediaFillable                    = ['folder_id', 'file_name', 'file_path', 'file_thumbs', 'file_type', 'file_icon', 'file_alt'];
    public static $widgetFillable                   = ['widget_title', 'widget_module', 'widget_content', 'widget_type', 'widget_qty', 'widget_style', 'widget_column', 'widget_state', 'widget_info', 'widget_folder', 'widget_by', 'widget_status'];
    public static $layoutConfigFillable             = ['layout_id', 'widget_id', 'content_column', 'modules', 'type', 'position_show', 'layout_detail_id'];
    public static $webConfigFillable                = ['web_name', 'web_url', 'web_folder', 'web_logo', 'web_hotline', 'web_keyword', 'web_description', 'web_contact', 'web_info', 'web_copyright', 'language'];
    public static $bannerSlideFillable              = ['tieu_de', 'lien_ket', 'hinh_anh', 'banner_status'];
    public static $webStylesFillable                = ['style_name', 'style_note', 'style_file', 'style_access', 'style_created', 'style_author', 'style_status'];
    public static $articleFillable                  = ['cate_id', 'pages', 'title', 'alias', 'intro', 'image', 'date_post', 'date_off', 'author', 'view', 'comment', 'order'];

    /**
     * Mặc định các quyền cơ bản cho từng module
     * Xem ds: view; Cập nhật dữ liêu: update, Xóa dữ liệu: delete
     */
    public static $permissionDefault    = [
        ['name' => 'Xem danh sách', 'value' => 'view'],
        ['name' => 'Cập nhật dữ liệu', 'value' =>  'update'],
        ['name' => 'Xóa dữ liệu', 'value' =>  'delete'],
    ];

    /**
     * CÀI ĐẶT CÁC KEY SỬ DỤNG CHO CACHE
     * -- Các key này mặc định để sử dụng cho cache các thành phần trên website
     */
    public static
        $CACHE_FRONTEND_MENU    = 'fontend_menu',
        $CACHE_FRONTEND_WEBSTYLE= 'fontend_webstyles',
        $CACHE_FRONTEND_SLIDE   = 'fontend_bannerslide';

    //TRẠNG THÁI CẬP NHẬT
    public static
        $warning        = 'warning',
        $success        = 'success';

    //TRẠNG THÁI PERMISSION
    public static
        $permissionView   = 'view',
        $permissionUpdate = 'update',
        $permissionConfig = 'config',
        $permissionDelete = 'delete';

    //TRẠNG THÁI DỮ LIỆU
    public static
        $list   = 'list',
        $create = 'create',
        $update = 'update',
        $delete = 'delete',
        $setting = 'setting';

    //TÊN BUTTON
    public static
        $listNameButton     = 'Danh sách',
        $listClassButton    = 'btn btn-primary btn-sm',
        $listIconButton     = '<i class="fa fa-list-ul" aria-hidden="true"></i>',
        $createNameButton   = 'Thêm mới',
        $createClassButton  = 'btn btn-success btn-sm',
        $createIconButton   = '<i class="fa fa-plus-square" aria-hidden="true"></i>';
        

    //THÔNG SỐ WIDGET INFO
    public static
        $widget_info_widget_title   = 'widget_title',
        $widget_info_widget_content = 'widget_contents',
        $widget_info_content_title  = 'content_title',
        $widget_info_content_image  = 'content_image',
        $widget_info_content_update = 'content_update',
        $widget_info_content_intro  = 'content_intro',
        $widget_info_content_type   = 'content_type'; //chủ đề widget
    
        //CÁC TRƯỜNG ĐỂ SẮP XẾP HIỂN THỊ
    public static
        $sortFieldList   = 'fdetail_order ASC';

    //CÁC TABLE MẶC ĐỊNH ĐỂ SỬ DỤNG TRONG CÁC MODULES
    public static
        $table_fillable         = 'fillable',
        $table_contents         = 'contents',
        $table_webstyles        = 'webstyles',
        $table_banners          = 'banners',
        $table_webThemes        = 'themes',
        $table_webConfig        = 'configs',
        $table_fieldDetail      = 'field_details',
        $table_fieldPermission  = 'permissions',
        $table_media            = 'media',
        $table_translation      = 'translation',
        $table_pages            = 'pages',
        $table_layout           = 'layouts',
        $table_layout_blocks    = 'layout_blocks',
        $table_layout_details   = 'layout_details',
        $table_category         = 'categories',
        $table_widget           = 'widgets',
        $table_layoutconfig     = 'layoutconfigs',
        $table_group_detail     = 'permissiongroup_details',
        $table_widgetColumns    = 'widgetcolumns',
        $table_moduleConfig     = 'module_configs',
        $table_contact          = 'contacts';

    //THƯ MỤC UPLOADS
    public static
        $public_path    = 'public/',
        $uploads_path    = 'uploads/';

    public static $imageExtensionAllowUpload = ['jpg','png','gif','ico'];

    //CÁC BIẾN MẶC ĐỊNH
    public static
        $defaultThemes      = 'mtThemes',
        $languageActived    = 'vietnam';

    /**
     * GET THEMES
     */
    public static function get_themes() {

        $webConfig  = WebConfig::all();

        return $webConfig['themes'];

    }

    /**
     * GET STYLE FOR WEBSITE
     */
    public static function get_webstyles() {

        $webStyle   = frontendWebStyles::all();

        return $webStyle;

    }


    /**
     * GET FILLABLE
     * $getKey: fillable hay array (fillable, type)
     */
    public static function parse_Fillable($module, $getKey='') {

        $fillable   = Fillable::all();
        
        $data   = [];

        if(isset($fillable[$module])) {

            $getFillAble    = json_decode($fillable[$module], true); //Return is array

            if(isset($getFillAble[$getKey])) {

                $data = $getFillAble[$getKey];

            } else {
                $data = $getFillAble;
            }

        }

        return $data;


    }

    /**
     * GET URL
     */
    public static function get_url($extend=[]) {

        $webConfig  = WebConfig::all();
        
        $baseUrl = $webConfig['url'];

        if(!empty($extend)) {
            
            foreach($extend as $alias) {

                $baseUrl .= '/'.$alias;

            }

        }

        return $baseUrl;
        
    }

    public static function findTable() {

        return [
            /**
             * LIST TABLE HERE
             */
            'configs'                   => 'web_configs',
            'webstyles'                 => 'web_styles',
            'settings'                  => 'settings',
            'articles'                  => 'articles',
            'products'                  => 'articles',
            'banners'                   => 'banners',
            'contents'                  => 'articles',
            'contents_detail'           => 'article_details',
            'fields'                    => 'field_configs',
            'fields_details'            => 'field_details',
            'field_details'             => 'field_details',
            'fields_groups'             => 'field_groups',
            'fillable'                  => 'fillable',
            'pages'                     => 'pages',
            'language'                  => 'languages',
            'languagekeys'              => 'language_keys',
            'translation'               => 'language_translates',
            'users'                     => 'users',
            'permissions'               => 'permissions',
            'permission_details'        => 'permission_details',
            'groups'                    => 'groups',
            'module_configs'            => 'module_configs',
            'moduleconfig'              => 'module_configs',
            'themes'                    => 'web_themes',
            'imagesize'                 => 'media_sizes',
            'media'                     => 'medias',
            'layouts'                   => 'layouts',
            'layout_blocks'             => 'layout_blocks',
            'layout_blocks'             => 'layout_blocks',
            'layout_details'            => 'layout_details',
            'layoutconfigs'             => 'layout_configs',
            'permissiongroups'          => 'permission_groups',
            'permissiongroup_details'   => 'permission_group_details',
            'categories'                => 'categories',
            'category'                  => 'categories',
            'widgets'                   => 'widgets',
            'widget'                    => 'widgets',
            'widgetcolumns'             => 'widget_column',
            'contacts'                  => 'contacts',
            'comment'                  => 'comments',
        ];

    }


    /**
     * LẤY DỮ 
     */
    public static function get_Column_From_Module($module='') {

        $data   = [
            'pages'     => ['id', 'page_title'],
            'language'  => ['id', 'language_name'],
            'category'  => ['id', 'cate_title']
        ];

        $result = false;

        if(isset($data[$module])) {

            $result = $data[$module];

        }

        return $result;

    }

    /*
     |===============================================================================================
     |  GET DATA FOM SQL - RETURN VALUE AND KEY FROM FILLABLE
     |  * Tải dữ liệu từ CSDL, Tải tất cả, key lấy từ fillable
     |===============================================================================================
     */
    public static function loadFirstDataSQL($condition='', $module, $columnKey='') {

        $data   = [];

        GlobalController::set_table($module);
        $sql = new SQLDatabase;

        //get data
        $get_data     = $sql->get_data('first', $condition);

        //Get fillable
        $getFillable    = self::parse_Fillable($module, 'fillandtype');

        if($get_data) {

            if(is_array($columnKey) && !empty($columnKey)) {

                foreach ($columnKey as $items) {

                    if(isset($get_data->$items)) {

                        $data += [$items  =>  $get_data->$items];

                        //SELECTED MUTIPLE SELECT
                        if(isset($getFillable[$items]) && $getFillable[$items] == 'multipleselect') {

                            $getSelectedColumn  = self::get_Column_From_Module($items);

                            if(isset($getSelectedColumn) && !empty($getSelectedColumn)) {
                                
                                $selectColumn           = self::selected_data($items, $getSelectedColumn);
                            
                                $selectColumnID         = isset($selectColumn['id']) ? $selectColumn['id'] : '';
                                $selectColumnInitial    = isset($selectColumn['initial']) ? $selectColumn['initial'] : '';

                                $data += [$items.'_multipleselect'  =>  $selectColumnID];
                                $data += [$items.'_multipleselect_initial'  =>  $selectColumnInitial];

                            }
                            
                        }

                        if(isset($getFillable[$items]) && $getFillable[$items] == 'chooseimage') {

                            $data += [$items.'_images'  =>  $get_data->$items];
                            
                        }


                    }

                }

            }

        }

        return $data;

    }

    public static function loadListDataSQL($condition='', $module, $columnKey='', $select='*', $limit='') {

        $data   = [];

        GlobalController::set_table($module);
        $sql = new SQLDatabase;

        //get data
        $get_data     = $sql->get_data('get', $condition, $select, $limit);

        if($get_data) {

            foreach ($get_data as $key=>$value) {

                if(is_array($columnKey) && !empty($columnKey)) {

                    foreach ($columnKey as $items) {
    
                        if(isset($value->$items)) {
    
                            $data[$key][$items] = $value->$items;
    
                        }

                        //Nếu tồn tại category_id thì sẽ lấy alias của category đó
                        if($items == 'cate_id') {

                            $cate_id    = $value->cate_id;
                            $art_id     = $value->id;
                            $art_alias  = $value->alias;

                            $content_alias  = self::artLinkAlias($art_id, $art_alias);
                            
                            $data[$key]['art_link'] = self::baseLinkContent($content_alias, $cate_id);

                        }
    
                    }

                    
    
                }

            }

        }

        return $data;

    }

    /*
     |===============================================================================================
     |  BASE URL CONTENT, PRODUCT
     |  * THIẾT LẬP ĐƯỜNG DẪN CHO BÀI VIẾT HOẶC SẢN PHẨM
     |===============================================================================================
     */
    public static function urlAlias($rootLink, $alias='', $extends='') {

        $get_url = self::get_url();

        $rootReplace    = str_replace('root', $get_url, $rootLink);
        $rootReplace    = str_replace('ROOT', $get_url, $rootReplace);
        $rootReplace    = str_replace('root', $get_url, $rootReplace);

        $baseURL        = $rootReplace;

        if($alias != '') {
            $baseURL    .= '/'.$alias;
        } else {
            $baseURL    .= '/'.$extends;
        }

        return $baseURL;

    }

    //Get language active
    public static function get_language() {
        return static::$languageActived;
    }

    /**
     * GET MODULE AND ACTION
     */
    public static function get_web_action($module, $action='', $loadid='') {
        return [
            'module'    => $module,
            'action'    => $action,
            'loadid'    => $loadid
        ];
    }

    /**
     * PARSE JSON
     */
    public static function parse_json($data) {

        return json_encode($data, JSON_UNESCAPED_UNICODE);

    }

    /**
     * GET TIME KEY
     */
    public static function getCacheTimeKey($modules, $key='time') {
        return config('app.cache.'.$modules.'.'.$key);
    }
    
    /**
     * GET CACHE KEY
     */
    public static function getCacheKey($modules, $key='') {
        $key        = strtoupper($key);
        $cacheKey  = config('app.cache.'.$modules.'.key');
        return $cacheKey."_".$key;
    }

    /**
     * CLEAR CACHE
     * $extends: Thêm tiền tố phía sau, vd: cache thêm user_id chẳng hạn
     */
    public static function clearCache($modules, $key='') {

        $cacheKey  = self::getCacheKey($modules, $key);

        cache()->forget($cacheKey);

    }

    /**
     * CHECK SESSION LOGIN
     */
    public static function check_login($type = 'admin') {

        $result = false;

        if(Session::has($type) && Session::get($type) == 'admin') {
            $result = true;
        }

        return $result;
    }

    //DATABASE
    //SET TABLE
    public static function set_table($module) {   
        $table_data = self::findTable();
        if(isset($table_data[$module]) && $table_data[$module] != '') {
            static::$table = $table_data[$module];
        } else {
            echo Config::get('constants.alert.table_notfound');
            exit();
        }
    }

    //GET TABLE
    public static function get_table() {
        return static::$table;
    }
    
    //SET FILLABLE
    public static function set_fillable($array_data) {
        if(isset($array_data) && !empty($array_data)) {
            static::$fillable = $array_data;
        } else {
            echo Config::get('constants.alert.fillable_empty');
            exit();
        }
    }

    //GET FILLABLE
    public static function get_fillable() {
        return static::$fillable;
    }

    /**
     * GET VIEW
     */
    public static function get_view($module='autoload', $page='list') {

        $themes = self::get_themes();

        if (view()->exists('templates.'.$themes.'.admin.modules.'.$module.'.'.$page))
        {
            $viewblade = 'templates.'.$themes.'.admin.modules.'.$module.'.'.$page;
        } 
        else if(view()->exists('templates.'.$themes.'.admin.modules.autoload.'.$page)) {
            $viewblade = 'templates.'.$themes.'.admin.modules.autoload.'.$page;
        }
        else {
            $viewblade = 'templates.'.$themes.'.admin.modules.errors.'.$page;
        }

        return $viewblade;

    }

    /**
     * INDEX GET VIEW
     */
    public static function index_get_view($page='home') {

        $themes = self::get_themes();

        if (view()->exists('templates.'.$themes.'.pages.'.$page))
        {
            $viewblade = 'templates.'.$themes.'.pages.'.$page;
        } 
        else {
            $viewblade = 'templates.'.$themes.'.pages.errors.'.$page;
        }

        return $viewblade;

    }

    /**
     * HIỂN THỊ BUTTONS LIST
     */
    public static function admin_button_header($module, $action='list', $name='', $class='', $icon='') {

        switch($action) {
            case self::$create: //create
                $buttonName     = $name != '' ? $name : self::$createNameButton;
                $buttonClass    = $class != '' ? $class : self::$createClassButton;
                $buttonIcon     = $icon != '' ? $icon : self::$createIconButton;
                break;
            case self::$update: //update
                $buttonName     = $name != '' ? $name : self::$createNameButton;
                $buttonClass    = $class != '' ? $class : self::$createClassButton;
                $buttonIcon     = $icon != '' ? $icon : self::$createIconButton;
                break;
            default:
                $buttonName     = $name != '' ? $name : self::$listNameButton;
                $buttonClass    = $class != '' ? $class : self::$listClassButton;
                $buttonIcon     = $icon != '' ? $icon : self::$listIconButton;
                break;

        }

        return [
            'url'   => self::get_url(['admin', $module, $action]),
            'name'  => $buttonName,
            'class' => $buttonClass,
            'icon'  => $buttonIcon
        ];

    }

    /*
     |===============================================================================================
     |  GLOABAL FUNCTION
     |  ADD TO DATABASE
     |===============================================================================================
     */
    //THÊM QUYỀN HẠN
    public static function createPermission($dataArray='') {

        GlobalController::set_fillable(self::$permissionFillable);
        GlobalController::set_table(self::$table_fieldPermission);
        $sql = new SQLDatabase;

        $parentCreated  = false;

        if(!empty($dataArray)) {

            if(isset($dataArray['data']) && !empty($dataArray['data'])) {

                $permissionData = $dataArray['data'];

                if(isset($permissionData['name']) && $permissionData['name'] != '' && $permissionData['value'] && $permissionData['value'] != '') {

                    $parentCreated = $sql->update_or_create([
                        'name'          => $permissionData['name'],
                        'parent_id'     => 0,
                        'description'   => 'Cho phép '.$permissionData['name'].': Thêm/Sửa/Xóa',
                        'value'         => $permissionData['value'],
                        'status'        => 1
                    ], ['id' => NULL]);

                }

            }

            if($parentCreated == true && isset($dataArray['detail']) && !empty($dataArray['detail'])) {

                $newID  = $sql->get_max_id();

                foreach($dataArray['detail'] as $dItems) {

                    if(isset($dItems['name']) && $dItems['name'] != '' && $dItems['value'] && $dItems['value'] != '') {

                        $sql->update_or_create([
                            'name'          => $dItems['name'],
                            'parent_id'     => $newID,
                            'description'   => NULL,
                            'value'         => $dItems['value'],
                            'status'        => 1
                        ], ['parent_id' => $newID, 'id' => NULL]);

                    }

                }
                
            }

        }

    }

    /*
     |===============================================================================================
     |  GLOABAL FUNCTION
     |  GET MODULES
     |  * THIẾT LẬP GIÁ TRỊ MODULES CHO TỪNG PAGE: CARTORDER, PRODUCT, STOCK,....
     |  * Lấy giá trị từ Database, trả về các giá trị cần thiết để sử dụng trong module
     |===============================================================================================
     */
    public static function getModuleConfig($pages = '') {

        self::set_table(self::$table_moduleConfig);
        $sql = new SQLDatabase;

        $message = [];

        /**
         * CONFIG SHOW MODULES
         */
        $keys_data          = [];
        $cols_data          = [];
        $header             = [];
        $datatable_config   = [];
        $buttons            = [];
        if($pages != '') {
            $get_module = $sql->get_data('first', ['pages'=>$pages]);
            if($get_module) {
                $module_data  = json_decode($get_module->key_modules);
                foreach($module_data as $cols_items) {
                    $keys_data[]    = $cols_items->keys;
                    $cols_data[]    = [
                        'keys'  => $cols_items->keys, //data: column lấy dữ liệu từ database
                        'width' => $cols_items->width,
                        'class' => $cols_items->class,
                        'type'  => $cols_items->type,
                    ];
                    $header[]   = $cols_items->label;
                }
                $keys_data[]    = 'buttons';
                $cols_data[]    = [
                    'keys'  => 'buttons', //data: column lấy dữ liệu từ database
                    'width' => 150,
                    'class' => 'text-center',
                    'type'  => 'text',
                ];
                $header[]   = 'Action';

                $datatable_config = self::datatableConfig($get_module, $cols_data);

            } else {
                $message[]  =  Config::get('constants.alert.page_empty');
            }
        } else {
            $message[]  =  Config::get('constants.alert.page_empty'); //Trang không tồn tại
        }

        return [
            'cols'      => $cols_data,
            'keys'      => $keys_data,
            'button'    => $buttons,
            'header'    => $header,
            'config'    => isset($datatable_config['config']) ? $datatable_config['config'] : [],
            'error'     => $message
        ];

    }

    /**
     * LẤY THÔNG TIN WIDGET
     */
    public static function getWidget($widgetID, $render="") {

        self::set_table(self::$table_widget);
        $sql = new SQLDatabase;

        $get_data   = $sql->get_data('first', ['id' => $widgetID]);

        $fetchData   = [];

        if($get_data) {

            $fetchData   = $get_data;

            if($render != '') {

                $fetchData   = isset($get_data->$render) ? $get_data->$render : 'Unknown';

            }

        }

        return $fetchData;

    }

    /**
     * PHÂN TÍCH GIÁ TRỊ MODULES
     * CÀI ĐẶT CHẠY CHO DATATABLE SEVERSIDE
     */
    public static function datatableConfig($data, $module_key='') {

        $feild_config   = [];

        /**
         * $feild_config: Gọi các giá trị cấu hình hiển thị cho datatable
         */
        if(isset($data->page_length) && $data->page_length > 0) {
            $feild_config[] = $data->page_length;
        }

        if(isset($data->order_by) && $data->order_by != '') {
            $feild_config[] = json_decode($data->order_by);
        }

        if(isset($data->search_box)) {
            $feild_config[] = $data->search_box;
        }

        if(isset($data->show_paging)) {
            $feild_config[] = $data->show_paging;
        }

        return [
            'config'    => $feild_config
        ];

    }

    /*
     |===============================================================================================
     | GLOABAL FUNCTION SELECTED
     |===============================================================================================
     */
    //SELECTED DATA
    //$column: Các cột để lấy dữ liệu
    public static function selected_data($table, $column, $condition='') {

        $data_initial   = [];

        if(is_array($column) && !empty($column)) {

            self::set_table($table);
            $sql = new SQLDatabase;

            $id     = 'Not found column';
            $text   = 'Not found column';

            $data_initial   = [];

            $get_data = $sql->get_data('first', $condition);

            if($get_data) {

                $column_0   = isset($column[0]) ? $column[0] : '';
                $column_1   = isset($column[1]) ? $column[1] : '';

                $id     = $column_0 != '' ? $get_data->$column_0 : 'Not found column';
                $text   = $column_1 != '' ? $get_data->$column_1 : 'Not found column';

                $data_initial = [
                    [
                        'id'    => $id,
                        'text'  => $text
                    ]
                ];

            }

        }

        return [
            'id'        => $id,
            'initial'   => self::parse_json($data_initial)
        ];

    }

    //Get themes list
    public static function get_themes_list() {

        self::set_table(self::$table_webThemes);
        $sql = new SQLDatabase;

        $data = [];

        $get_data   = $sql->get_data('get');
        if($get_data) {
            foreach ($get_data as $items) {
                $data[] = [
                    'value' => $items->language_key,
                    'text'  => $items->language_name
                ];
            }
        }

    }

    //selected themes
    public static function selected_themes() {

    }

    //Selected group
    public static function selected_group($group_id) {

        $data_initial   = [];

        if($group_id != '') {

            self::set_table('groups');
            $sql = new SQLDatabase;

            $get_data = $sql->get_data('first', ['id' => $group_id], 'group_name');
            if($get_data) {

                $name  = $get_data->group_name;

                $data_initial = [
                    [
                        'id'    => $group_id,
                        'text'  => $name
                    ]
                ];

            }

        }

        return [
            'id'        => $group_id,
            'initial'   => self::parse_json($data_initial)
        ];

    }

    public static function selected_pages($pages='') {

        $data_initial   = [];

        if($pages != '') {

            self::set_table(GlobalController::$table_pages);
            $sql = new SQLDatabase;

            $get_data = $sql->get_data('first', ['page_modules' => $pages], 'page_title');
            if($get_data) {

                $name  = $get_data->page_title;

                $data_initial = [
                    [
                        'pages' => $pages,
                        'text'  => $name
                    ]
                ];

            }

        }

        return [
            'pages'     => $pages,
            'initial'   => self::parse_json($data_initial)
        ];

    }

    //Selected group
    public static function selected_category($cate_id) {

        $data_initial   = [];

        if($cate_id != '') {

            self::set_table(self::$table_category);
            $sql = new SQLDatabase;

            $get_data = $sql->get_data('first', ['id' => $cate_id], 'cate_title');
            if($get_data) {

                $title  = $get_data->cate_title;

                $data_initial = [
                    [
                        'id'    => $cate_id,
                        'text'  => $title
                    ]
                ];

            }

        }

        return [
            'id'        => $cate_id,
            'initial'   => self::parse_json($data_initial)
        ];

    }

    //===============================================================================================
    //=== XỬ LÝ FORM ================================================================================
    //===============================================================================================
    //FORM-GET, Lấy thông tin và xử lý mảng 2 chiều, về mảng 1 chiều để lấy dữ liệu
    //$key : Gía trị mặc định cần lấy
    public static function form_get_process($data, $getKey='') {

        $data_array = [];

        if(!empty($data)) {
            foreach ($data as $items) {
                foreach ($items as $key=>$d_items) {
                    $data_array[$key]   = $d_items;
                }
            }
        }        

        if($getKey != '' && isset($data_array[$getKey])) {

            $results = $data_array[$getKey];

        } else {

            $id         = isset($data_array['id']) ? $data_array['id'] : '';
            $type       = isset($data_array['type']) ? $data_array['type'] : '';
            $modules    = isset($data_array['modules']) ? $data_array['modules'] : '';
            $pages      = isset($data_array['pages']) ? $data_array['pages'] : '';
            $themes     = isset($data_array['themes']) ? $data_array['themes'] : '';

            $results = [
                'id'        => $id,
                'type'      => $type,
                'pages'     => $pages,
                'themes'    => $themes,
                'modules'   => $modules
            ];

        }

        return $results;

    }

    public static function form_data_get($data) {

        $data_array = [];

        if(!empty($data)) {
            foreach($data as $key=>$data_items) {
                $key_name               = $data_items->name;
                $data_array[$key_name]   = $data_items->value;
            }
        }

        $id         = isset($data_array['id']) ? $data_array['id'] : '';
        $type       = isset($data_array['type']) ? $data_array['type'] : '';
        $modules    = isset($data_array['modules']) ? $data_array['modules'] : '';
        $pages      = isset($data_array['pages']) ? $data_array['pages'] : '';
        $themes     = isset($data_array['themes']) ? $data_array['themes'] : '';

        return [
            'id'        => $id,
            'type'      => $type,
            'pages'     => $pages,
            'themes'    => $themes,
            'modules'   => $modules
        ];

    }

    //FORM GET DATA
    public static function form_get_data($data, $module='') {

        $data_get       = [];
        $data_data      = [];
        $data_fillable  = [];
        $form_detail    = [];

        //Get fillable and type (Để biết type của fields đó là gì)
        $getFillAndType    = self::parse_Fillable($module, 'fillandtype');

        

        if(!empty($data)) {

            foreach($data as $items) {

                foreach($items->get as $key=>$data_items) {
                    $key_name               = $data_items->name;
                    $data_get[$key_name]   = $data_items->value;
                }

                foreach($items->data as $data_items) {

                    $columnName     = $data_items->name;
                    $columnValue    = $data_items->value;

                    if(isset($getFillAndType[$columnName])) {

                        switch ($getFillAndType[$columnName]) {

                            case 'datetime':
                                $columnValue  = self::convertDate($columnValue, 'Y-m-d H:i:s');
                                break;
                            case 'date':
                                $columnValue  = self::convertDate($columnValue, 'Y-m-d');
                                break;

                        }

                    }

                    $key_name               = $columnName;
                    $data_data[$key_name]   = $columnValue;
                    $data_fillable[]        = $columnName;

                }
                
            }

        }

        return [
            'data'      => [
                'get'       => $data_get,
                'data'      => $data_data,
                'fillable'  => $data_fillable
            ],
            'detail'    => $form_detail
        ];

    }

    /*
     |===============================================================================================
     | GLOABAL FUNCTION IMAGE
     |===============================================================================================
     */
    ///UPLOAD IMAGE
    public static function uploadImages($request, $folder_id, $image_data, $model, $condition, $linkFileRemove='') {

        $status     = GlobalController::$warning;
        $alert      = Config::get('constants.alert.not_update');
        $message    = [];

        $pathUploads    = GlobalController::$public_path.GlobalController::$uploads_path; //Default Folder update
        $fileName       = '';

        if(!empty($image_data)) {

            //Get path folder
            if($folder_id != 0) {
                $getFolder = $model->get_data('first', ['id' => $folder_id]);
                if($getFolder) {
                    $pathUploads = $getFolder->file_path;
                }
            }            

            foreach ($image_data as $key=>$items) {

                $fileKey    = isset($items[0]) ? $items[0] : '';
                $extension  = isset($items[1]) ? $items[1] : GlobalController::$imageExtensionAllowUpload;

                if($fileKey != '') {

                    $getImageData = self::imageData($request, $fileKey, $extension);
                    // if(!empty($getImageData)) {
                    //     $message += $getImageData;  //Set message from imageData()
                    // }

                    if(isset($getImageData['status']) && $getImageData['status'] == 'success') {

                        $file       = $getImageData['data']['file']; //Using for move file to folder path
                        $fileName   = $getImageData['data']['filename'];
                        $fileAlt    = $getImageData['data']['alt']; //extension
                        $filePath   = $pathUploads.$fileName;
    
                        //Thực hiện update data
                        $update     = $model->update_or_create([
                            'folder_id' => $folder_id,
                            'file_name' => $fileName,
                            'file_path' => $filePath,
                            'file_type' => 'image',
                            'file_alt'  => $fileAlt
                        ], $condition);
    
                        if($update) {

                            $file->move(public_path(str_replace(self::$public_path, '', $pathUploads)), $fileName);

                            $status = GlobalController::$success;
                            $alert  = Config::get('constants.alert.updated');

                        }
    
                    }

                } else {
                    $message[]  = TranslationController::translation(Config::get('constants.alert.file_denied'));
                }

            }

        }

        return [
            'status'    => $status,
            'alert'     => TranslationController::translation($alert),
            'message'   => $message,
            'imagePath' => $pathUploads.$fileName,
            'imageName' => $fileName
        ];

    }


    //GET IMAGE INFO
    public static function imageData($request, $fileKey, $extAllowPost='') {

        $status     = GlobalController::$warning;
        $message    = [];

        $data       = [];

        $linkimages = ''; //Url update to database
        $fileName   = '';

        if(is_array($extAllowPost) && !empty($extAllowPost)) {
            

            if($request->hasFile($fileKey)){

                $fileImg    = $request->file($fileKey);
                $file_name  = $fileImg->getClientOriginalName();
                $ext        = $fileImg->getClientOriginalExtension();
                $fileName   = self::changeFileName($file_name, $ext);

                if(in_array($ext, $extAllowPost, true)) {

                    $data = [
                        'file'      => $fileImg, //File move to folder
                        'filename'  => $fileName,
                        'ext'       => $ext,
                        'alt'       => $file_name
                    ];

                } else {

                    $message[]  = Config::get('constants.alert.file_denied'); //Định dạng không cho phép upload

                }
                
            }

        } else {

            $message[]  = Config::get('constants.alert.file_allow_ext'); //Định dạng file chưa được khai báo

        }

        if(empty($message)) {
            $status = GlobalController::$success;
        }

        return [
            'status'    => $status,
            'message'   => $message,
            'data'      => $data
        ];

    }

    //POST IMAGE
    public static function postImage($path, $request, $model, $data, $condition, $remove_data='') {

        $links_data = [];
        $move_data  = [];
        $message    = [];
        $flag       = true;

        $public_path    = str_replace('public/','', $path);

        if(!empty($data)) {

            foreach ($data as $key=>$items) {

                $sql_cols   = $items[0];
                $input_name = $items[1];
                $extension  = isset($items[2]) ? $items[2] : ['jpg','png','gif','ico'];

                $getImg = self::getImage($request, $path, $input_name);

                if(!empty($getImg)) {

                    if(in_array($getImg['ext'], $extension, true)) {

                        $links_data += [$sql_cols => $getImg['links']];
                        $move_data[] = [$getImg['files'], $getImg['filename']];

                    } else {
                        $message[]  = 'File '.$getImg['filename'].' không được phép uploads lên ứng dụng, do không đúng định dạng';
                    }
                }

            }

        }

        if(!empty($links_data)) {

            $update = $model->update_data($links_data, $condition);

            if($update) {

                if(!empty($move_data)) {
                    foreach($move_data as $file_items) {
                        $fileImg    = $file_items[0];
                        $fileName   = $file_items[1];
                        $fileImg->move(public_path($public_path),$fileName);
                    }
                }

                //Remove old image
                self::removeFile($remove_data);

            }

        }

        return $message;

    }

    /**
     * REMOVE FILE
     * list is array
     */
    public static function removeFile($list) {
        if(is_array($list) && !empty($list)) {
            foreach ($list as $items) {
                $remove_path = public_path(str_replace('public/', '', $items));
                if (File::exists($remove_path)) {
                    File::delete($remove_path);
                }
            }
        }
    }

    //Get file
    public static function getImage($request, $path, $key) {

        $linkimages = '';
        $fileName   = '';

        $data       = [];

        if($request->hasFile($key)){
            $fileImg    = $request->file($key);
            $file_name  = $fileImg->getClientOriginalName();
            $ext        = $fileImg->getClientOriginalExtension();
            $fileName   = self::changeFileName($file_name,$ext);

            $linkimages = $path.'/'.$fileName;

            $data = [
                'files'     => $fileImg,
                'links'     => $linkimages,
                'filename'  => $fileName,
                'ext'       => $ext
            ];
        }

        return $data;

    }

    /**
     * Create file images
     */
    public static function changeFileName($images, $ext, $extend='', $author='') {
		//cut string name
        $result         = "";
        $set_extends    = '';
        $str_cut        = explode('.'.$ext, $images);        
        switch($extend) {
            case 'date';
                $rand           = rand(11111, 99999);
                $set_extends    = '_'.date('d').'_'.date('m').'_'.date('Y');
                break;
            case 'author':
                $rand           = '';
                $set_extends    = self::convertViToEn($author);
                break;
            default:
                $rand           = rand(11111, 99999);
                $set_extends    = '';
                break;
        }
        $result = self::convertViToEn($str_cut[0]).'-'.$rand.$set_extends.'.'.$ext;
        return $result;
	}


    /**
     * Convert vi to en
     */
    public static function convertViToEn($value, $space='-', $length=0)
    {
        #---------------------------------a^
        $value = preg_replace('/(a|à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $value);
        $value = preg_replace('/(e|è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $value);
        $value = preg_replace('/(i|ì|í|ị|ỉ|ĩ)/', 'i', $value);
        $value = preg_replace('/(o|ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $value);
        $value = preg_replace('/(u|ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $value);
        $value = preg_replace('/(y|ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $value);
        $value = preg_replace('/(d|đ)/', 'd', $value);
        $value = preg_replace('/(A|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/', 'a', $value);
        $value = preg_replace('/(E|È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/', 'e', $value);
        $value = preg_replace('/(I|Ì|Í|Ị|Ỉ|Ĩ)/', 'i', $value);
        $value = preg_replace('/(O|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/', 'o', $value);
        $value = preg_replace('/(U|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/', 'u', $value);
        $value = preg_replace('/(Y|Ỳ|Ý|Ỵ|Ỷ|Ỹ)/', 'y', $value);
        $value = preg_replace('/(D|Đ)/', 'd', $value);
        #---------------------------------
        $value = str_replace("(", "", $value);
        $value = str_replace(")", "", $value);
        $value = str_replace(":", "", $value);
        $value = str_replace("%", "", $value);
        $value = str_replace("'", "", $value);
        $value = str_replace('"', '', $value);
        $value = str_replace('“', '', $value);
        $value = str_replace(' ', $space, $value);
        #---------------------------------
        $value = preg_replace('/[^A-Za-z0-9\-]/', $space, $value);
        $value = str_replace('--', $space, $value);
        $value = str_replace('/', $space, $value);
        #---------------------------------
        if($length > 0 && strlen($value)>=$length)
        {
            $value = mb_substr($value,0,140);
        }
        #---------------------------------
        return utf8_encode(strtolower($value));
    }

    public static function stripTags($string, $stripContent = false)
    {
        $string    = trim($string);
        $result    = strip_tags($string);
        return $result;
    }


    /*
     |===============================================================================================
     |  LAYOUT CONFIG - SHOW LAYOUT IN WEBSITE
     |  * TẢI VÀ HIỂN THỊ GIAO DIỆN WEBSITE NGƯỜI DÙNG
     |===============================================================================================
     */
    //GET LAYOUT BY OPTION
     public static function getLayout($option='index') {

        $data = [];

        GlobalController::set_table(GlobalController::$table_layout);
        $sql = new SQLDatabase;

        $get_layout = $sql->get_data('first', ['pages' => $option]);

        if($get_layout) {

            $data   = [
                'id'    => $get_layout->id,
                'name'  => $get_layout->name
            ];

        }

        return $data;

    }

    //GET 
    public static function getLayoutBlock($layoutID, $blockType='') {

        $layoutData = [];

        GlobalController::set_table(GlobalController::$table_layout_blocks);
        $sql        = new SQLDatabase;

        $condition  = [
            'where' => [['layout_id', $layoutID]]
        ];

        if(is_array($blockType) && !empty($blockType)) {
            $condition += ['whereIn'   => ['block' => $blockType]];
        }

        $get_layout = $sql->get_data('get', $condition);

        if($get_layout) {
    
            foreach ($get_layout as $items) {

                $block_id   = $items->id;
                $block_type = $items->block;

                $layoutBlock = [
                    'id'    => $block_id,
                    'block' => $block_type
                ];

                //Layout_detail
                GlobalController::set_table(GlobalController::$table_layout_details);
                $detailSQL      = new SQLDatabase;

                $layoutDetail   = [];

                $get_layout_detail = $detailSQL->get_data('get', ['block_id' => $block_id]);

                if($get_layout_detail) {

                    foreach ($get_layout_detail as $detailItems) {

                        $detailID           = $detailItems->id;
                        $detailClass        = $detailItems->layout_class;

                        $layoutDetail[] = [
                            'id'            => $detailID,
                            'class'         => $detailClass,
                            'layout_config' => self::getLayoutConfig($detailID)
                        ];

                    }

                }

                $layoutData[$block_type][] = [
                    'block'     => $layoutBlock,
                    'detail'    => $layoutDetail,
                    'column'    => count($layoutDetail)
                ];

            }

        }

        return $layoutData;

    }

    ///GET LAYOUT CONFIG
    public static function getLayoutConfig($layoutDetailID) {

        GlobalController::set_table(GlobalController::$table_layoutconfig);
        $sql        = new SQLDatabase;

        $data       = [];

        $get_layout = $sql->get_data('get', ['layout_detail_id'=>$layoutDetailID]);

        if($get_layout) {

            foreach ($get_layout as $items) {

                $widgetID       = $items->widget_id;

                $widget_title   = GlobalController::getWidget($widgetID, 'widget_title');

                $data[] = [
                    'layout_detail_id'  => $layoutDetailID,
                    'layout_id'         => $items->layout_id,
                    'widget_id'         => $widgetID,
                    'widget_title'      => $widget_title,
                    'content_column'    => $items->content_column,
                    'modules'           => $items->modules,
                    'type'              => $items->type,
                    'position_show'     => $items->position_show,
                ];

            }

        }

        return $data;

    }

    ///SHOW WIDGET CONTENT
    //$block_type: array, header, body, footer
    public static function showLayoutData($option='index', $block_type='') {

        //GET LAYOUT_ID FROM LAYOUT_ID
        if(intval($option) > 0) {
            $layout_id      = intval($option);
        } 
        //GET LAYOUT_ID FROM LAYOUT_OPTIONS
        else {
            $layout         = GlobalController::getLayout($option);
            $layout_id      = isset($layout['id']) ? $layout['id'] : '';
        }
        

        $block_data     = [];

        if(isset($layout_id) && intval($layout_id) > 0) {

            $layout_block   = GlobalController::getLayoutBlock($layout_id, $block_type);

            if(!empty($layout_block)) {

                foreach ($layout_block as $items) {

                    foreach ($items as $key=>$items_2) {

                        if(isset($items_2['detail'])) {

                            foreach($items_2['detail'] as $k=>$block_items) {

                                //LẤY DS HIỂN THỊ WIDGET CHO TỪNG BLOCK
                                $show_widget    = [];
                                $layout_config  = $block_items['layout_config'];
                                if(!empty($layout_config)) {
                                    foreach ($layout_config as $config_items) {

                                        $widget_id = $config_items['widget_id'];

                                        $show_widget[]  = self::showWidgetContent($widget_id);

                                    }
                                }

                                $block_data[$key][]   = [
                                    'id'            => $block_items['id'],
                                    'class'         => $block_items['class'],
                                    'layout'        => $show_widget,
                                    'layout_config' => $layout_config
                                ];

                            }

                        }

                    }

                }

            }

        } else {
            echo 'Không tìm thấy giao diện để hiển thị';
        }

        return $block_data;

    }

    /**
     * GET ROOT ALIAS
     */
    public static function baseLinkContent($content_alias, $cate_id, $extend='.html') {

        GlobalController::set_table(GlobalController::$table_category);
        $sql    = new SQLDatabase;

        $link     = [];

        $get_categories     = $sql->get_data('first', ['id' => $cate_id]);

        if($get_categories) {
            $link[] = $get_categories->cate_alias;
        }

        $link[] = $content_alias.$extend;

        return self::get_url($link);

    }

    /**
     * GET ID CONTENT BY ALIAS
     */
    public static function getContentAliasID($alias, $cutStr=4, $startCut=0) {

        return (int)preg_replace('/[^0-9]/','',substr($alias,$startCut,$cutStr));

    }

    /**
     * TẢI DS BÀI VIẾT THEO CẤU HÌNH WIDGET
     */
    public static function widgetContentList($condition='', $widgetShowContent='') {

        GlobalController::set_table(GlobalController::$table_contents);
        $sql    = new SQLDatabase;

        $data   = [];
        $get_data   = $sql->get_data('get', $condition);

        if($get_data) {
            
            foreach ($get_data as $items) {

                $content_alias  = self::artLinkAlias($items->id, $items->art_alias);

                $data[] = [
                    'link'      => self::baseLinkContent($content_alias, $items->cate_id),
                    'title'     => $items->title,
                    'alias'     => $items->alias,
                    'intro'     => $items->intro,
                    'image'     => $items->image,
                    'author'    => $items->author,
                ];

            }

        }

        return $data;

    }

    /**
     * LẤY URL BAO GỒM: ID, ALIAS CỦA BÀI VIẾT
     */
    public static function artLinkAlias($id='', $alias='') {

        return $id.'-'.$alias;
    }


    /**
     * SHOW WIDGET CONTENT
     */
    public static function showWidgetContent($widgetID) {

        GlobalController::set_table(GlobalController::$table_widget);
        $sql    = new SQLDatabase;

        $show_content   = [];

        $get_data = $sql->get_data('first', ['id' => $widgetID]);

        if($get_data) {

            $widget_title   = $get_data->widget_title;
            $widget_module  = $get_data->widget_module;
            $widget_content = $get_data->widget_content;
            $widget_type    = $get_data->widget_type; //danh mục sp / bài viết
            $widget_qty     = $get_data->widget_qty; //Số lượng mẫu tin
            $widget_column  = $get_data->widget_column; //Xác định số cột để hiển thị các nội dung widet
            $widget_style   = $get_data->widget_style; //Style lại widget (css)
            $widget_state   = $get_data->widget_state;
            $widget_info    = json_decode($get_data->widget_info, true); //decode to array
            $widget_folder  = $get_data->widget_folder;
            
            switch ($widget_module) {
                ///KIỂM TRA WIDGET QUẢNG CÁO
                case 'widget':
                    $widget_title       = in_array('widget_title', $widget_info) ? $widget_title : '';
                    $widget_content     = in_array('widget_contents', $widget_info) ? $widget_content : '';
                    break;
                ///KIỂM TRA WIDGET NỘI DUNG
                case 'contents':

                    /**
                     * THIẾT LẬP ĐIÊU KIỆN HIỂN THỊ WIDGET
                     */
                    $widgetShowContent = '';

                    $widget_title       = in_array('widget_title', $widget_info) ? $widget_title : '';
                    $widget_content = [];
                    /**
                     * widget_content is array
                     */
                    $condition     = [];
                    $limit              = '';
                    if(intval($widget_type) > 0) {
                        $condition  = [
                            ['cate_id', $widget_type]
                        ];
                    }

                    if(intval($widget_qty) > 0) {
                        $limit  = [0, $widget_qty];
                    }

                    $widget_content  = GlobalController::loadListDataSQL($condition, GlobalController::$table_contents, GlobalController::$articleFillable, '*', $limit);
                    break;
                ///KIỂM TRA WIDGET MẶC ĐỊNH
                case 'default':
                    $widget_title       = in_array('widget_title', $widget_info) ? $widget_title : '';
                    $widget_content     = in_array('widget_contents', $widget_info) ? 'templates.mtThemes.widgets.'.$widget_folder : '';
                    break;
            }

            $show_content[] = [
                'widget_id'	=> $widgetID,
                'type'		=> $widget_module,
                'title'		=> $widget_title,
                'content'	=> $widget_content,
                'style'		=> $widget_style,
                'column'    => $widget_column,
                'info'      => $widget_info
            ];


        }

        return $show_content;
        
    }


    /**
     * SHOW ALERT CẬP NHẬT CHI TIẾT
     */
    public static function proccessUpdate($proccess) {

        $status     = self::$warning;
        $alert      = Config::get('constants.alert.not_update');

        if(!empty($proccess)) {

            if(in_array('failed', $proccess)) {
                $alert    = Config::get('constants.alert.not_update');
            } else {
                $status     = self::$success;
                $alert    = Config::get('constants.alert.updated');
            }

        }
        //Không có dữ liệu update
        else {
            $alert  = Config::get('constants.alert.data_update_empty');
        }

        return [
            'status'    => $status,
            'alert'     => $alert
        ];

    }

    /**
     * TĂNG VIEW NỘI DUNG LÊN 1
     * $sessionKey: TỪ KHÓA ĐỂ LƯU SESSION, Để khi tồn tại rồi thì sẽ ko tăng nữa
     */
    public static function updateViewContent($articleId, $table='articles', $sessionKey='VIEW'){

        GlobalController::set_table($table);
        $sql    = new SQLDatabase;

        $action     = false;
        $result     = false;

        $keyCheck   = $sessionKey.$articleId;
        $sessionKeyDefault = 'VIEW'.$articleId;

        //Kiểm tra session check có tồn tại không, nếu không tăng view, ngược lại không
        if(isset($articleId) && $articleId != '' && !Session::has($keyCheck) OR Session::get($keyCheck) != $sessionKeyDefault){

            $result  = $sql->incrementInt(['id'=>$articleId], 'view');

            Session::regenerate();
            if($result) {Session::put($keyCheck, $sessionKeyDefault);}

        }

    }


    /**
     * HÀM CHUYỂN ĐỔI NGÀY ĐỂ LƯU VÀO CSDL
     * $type: date: dạng ngày, datetime: dạng ngày giờ
	 */
	public static function convertDate($date, $format='Y-m-d') {
		$convert_date = date($format,strtotime(str_replace('/', '-', $date)));
		return $convert_date;
	}


    /**
     * SHOW HEADER
     */
    public function showHeaderFooter($module='') {

    }


}
