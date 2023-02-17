<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\GlobalController;

//CACHE APP MENU
use Facades\App\Repository\frontendMenu;
use Facades\App\Repository\frontendBannerSlide;
use Facades\App\Repository\Appmenu;
use Facades\App\Repository\WebConfig;
use Facades\App\Repository\loadHeaderFooter;

use App\Web_config;
use App\SQLDatabase;

use Redirect, Auth, Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');

        // Session::flush();

        //ADD SESSION TO USE
        $menu   = frontendMenu::all();
        Session::put('menu', $menu);
        // Session::forget('menu');

        //Header footer
        $header_footer  = loadHeaderFooter::all('ALL');

        Session::forget('header_footer');
        Session::put('header_footer', $header_footer);
        // Session::forget('header_footer');

        //ADD SESSION BANNER SLIDE
        $bannerSlide    = frontendBannerSlide::all();
        Session::put('banner_slide', $bannerSlide);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminIndex()
    {

        $webConfig  = WebConfig::all();

        $titlePage  = $webConfig['name'];

        $themes     = $webConfig['themes'];

		return view('templates.'.$themes.'.admin.modules.index.home', compact('themes', 'titlePage'));
    }


    //LOAD MENU ADMIN
    public function loadAdminMenu(Request $request) {

        $get_pt = $request->pt;

        Appmenu::set_pt($get_pt);

        return Appmenu::all(Auth::id());

    }

    //Hiển thị giao diện trang chủ
    public function index()
    {

        $webConfig      = WebConfig::all();

        $condition      = [
            ['cate_id', 23]
        ];

        // $header_footer  = loadHeaderFooter::all('ALL');
        $data       = GlobalController::loadListDataSQL($condition, GlobalController::$table_contents, GlobalController::$articleFillable, '*', [0,2]);
        $titlePage      = $webConfig['name'];
        $themes         = $webConfig['themes'];

        $webstyle       = GlobalController::get_webstyles();

        $web_action     = GlobalController::get_web_action('index');

        $layout_data    = GlobalController::showLayoutData('index', ['body']);

        return view('templates.'.$themes.'.pages.home', compact('themes', 'web_action', 'webstyle', 'titlePage', 'layout_data', 'webConfig', 'data'));

    }

    //Danh sách
    public function contentList($alias) {

        $webConfig      = WebConfig::all();

        $pageType       = 'list';
        $titlePage      = 'Errors';
        $themes         = $webConfig['themes'];
        $layout_data    = [];
        $data           = [];

        //Set table
        GlobalController::set_table(GlobalController::$table_category);
        $sql            = new SQLDatabase;

        $cateCondition  = [
            ['cate_status', 1],
            ['cate_alias', $alias]
        ];
        $get_category   = $sql->get_data('first', $cateCondition);
        if($get_category) {

            $layout_id  = $get_category->pages;
            $titlePage  = $get_category->cate_title;

            $cate_id    = $get_category->id;

            $data       = GlobalController::loadListDataSQL([
                ['cate_id', $cate_id]
            ], GlobalController::$table_contents, GlobalController::$articleFillable);

            $layout_data    = GlobalController::showLayoutData($layout_id, ['body']);

            $header_footer  = loadHeaderFooter::all('ALL');

            $pageView       = 'home';

        } else {
            $pageView   = '404';
        }

        $view       = GlobalController::index_get_view($pageView);

        return view($view, compact('themes', 'pageType', 'titlePage', 'layout_data', 'webConfig', 'data'));

    }

    /**
     * HIỂN THỊ CHI TIẾT BÀI VIẾT
     */
    public function contentDetail($alias, $id) {

        $module         = 'contents_detail';

        $webConfig      = WebConfig::all();

        $themes         = $webConfig['themes'];
        $layout_data    = [];

        $pageView   = 'contentdetails';

        $view       = GlobalController::index_get_view($pageView);

        $contentId  = GlobalController::getContentAliasID($id);

        //TĂNG VIEW LÊN +1
        GlobalController::updateViewContent($contentId, GlobalController::$table_contents);

        //GET AND SHOW CONTENT
        GlobalController::set_table($module);
        $sql        = new SQLDatabase;

        $data       = [];

        $get_data   = $sql->get_data('get', ['art_id' => $contentId]);
        if($get_data) {

            foreach ($get_data as $items) {
                $data[$items->art_detail_name] = $items->art_detail_value;
            }

        }

        $titlePage      = isset($data['title']) ? $data['title'] : 'Title error';

        return view($view, compact('themes', 'titlePage', 'layout_data', 'webConfig', 'data'));

    }

    //HIỂN THỊ GIAO DIỆN CÁC TRANG KHÁC THEO TỪNG MODULE


    //HIỂN THỊ GIAO DIỆN TÌM KIẾM
    public function search() {

        $titlePage  = 'TRANG TÌM KIẾM';

        $module         = 'contents_detail';

        $webConfig      = WebConfig::all();

        $themes         = $webConfig['themes'];
        $layout_data    = [];
        $data           = [];

        $pageView       = 'searchcontent';

        $view           = GlobalController::index_get_view($pageView);

        $module         = isset($_GET['module']) ? $_GET['module'] : '';
        $keySearch      = isset($_GET['keys']) ? $_GET['keys'] : '';

        //GET AND SHOW CONTENT
        GlobalController::set_table($module);
        $sql        = new SQLDatabase;

        $condition  = '';
        if($keySearch != '') {
            $condition  = [
                ['title', 'LIKE', '%'.$keySearch.'%']
            ];
        }

        $data       = GlobalController::loadListDataSQL($condition, GlobalController::$table_contents, GlobalController::$articleFillable);

        return view($view, compact('themes', 'titlePage', 'layout_data', 'webConfig', 'data'));

    }

    //Trang liên hệ
    public function contactPage($id,$module='contacts') {

        $webConfig      = WebConfig::all();

        $pageType       = 'list';
        $titlePage      = 'Liên hệ';
        $themes         = $webConfig['themes'];
        $layout_data    = [];

        //Set table
        GlobalController::set_table($module);
        $sql            = new SQLDatabase;

        $layout_id      = 11;

        $layout_data    = GlobalController::showLayoutData($layout_id, ['body']);
        // print_r($layout_data);
        // exit();
        $header_footer  = loadHeaderFooter::all('ALL');

        $pageView       = 'home';

        $view       = GlobalController::index_get_view($pageView);
        return view($view, compact('themes', 'pageType', 'titlePage', 'layout_data', 'webConfig','id'));

    }

    public function loadWidgetIndex(Request $request) {

        $status = 'warning';

        GlobalController::set_table(GlobalController::$table_widget);
        $sql    = new SQLDatabase;

        $data   = [];

        if($request->ajax()) {

            //wID
            $get        = GlobalController::form_get_process(json_decode($request->get));
            $wID         = $get['id'];

            $condition  = [
                ['id', $wID]
            ];

            $get_widget     = $sql->get_data('first', $condition);

            $data           = $get_widget->widget_content;

        }

        return [
            'status'    => 'success',
            'data'      => $data
        ];

    }

    public function saveContactPage(Request $req){
        $status     = GlobalController::$warning;

        if($req->ajax()){
            GlobalController::set_fillable(['contact_link', 'contact_name','contact_phone','contact_email','contact_content']);
            GlobalController::set_table(GlobalController::$table_contact);
            $sql    = new SQLDatabase;
            $c_id = $req->get("contact_link");
            $name = $req->get("contact_name");
            $phone = $req->get("contact_phone");
            $email = $req->get("contact_email");
            $note = $req->get("contact_note");
            $updateCondition    = [['id', '']];

            $update = $sql->update_or_create([
                "contact_link"=>$c_id,
                "contact_name"=>$name,
                "contact_phone"=>$phone,
                "contact_email"=>$email,
                "contact_content"=>$note,
            ],$updateCondition);
        }
        if($update){
            $status = GlobalController::$success;
        }

        return response()->json([
            'status'    => $status,
        ]);
    }

}
