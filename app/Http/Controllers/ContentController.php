<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\GlobalController;

use App\SQLDatabase;

use File, Config;

class ContentController extends Controller
{
    
    public static $table        = 'contents'; // == articles
    public static $table_detail = 'contents_detail'; // == articles_details

    
    /**
     * ADD ARTICLES LIST
     * -- Thêm danh sách bài viết
     */
    public function addArticle($data) {

        $status         = GlobalController::$warning;
        $alert          = Config::get('constants.alert.not_update');

        $process   = [];

        GlobalController::set_table(self::$table);
        GlobalController::set_fillable(['cate_id', 'art_title', 'art_alias', 'art_intro', 'art_image', 'art_date_post', 'art_date_end', 'art_created_by', 'art_order', 'art_hot', 'art_status']);
        $sql    = new SQLDatabase;

        $insert_data    = [];

        $post_id        = '';

        if(!empty($data)) {

            //Xóa dữ liệu cũ
            foreach ($data as $key=>$items) {

                $cate_id    = $key  == 'cate_id' ? $items : '';
                $title      = $key  == 'title' ? $items : '';
                $alias      = $key  == 'alias' ? $items : '';
                $date_post  = $key  == 'date_post' ? $items : '';
                $date_off   = $key  == 'date_off' ? $items : '';
                $author     = $key  == 'author' ? $items : '';
                $intro      = $key  == 'intro' ? $items : '';
                $image      = $key  == 'art_image' ? $items : '';
                $hot        = $key  == 'hot' ? $items : '';
                $language        = $key  == 'language' ? $items : '';

                if($cate_id != '') {
                    $insert_data += ['cate_id'=>$cate_id];
                }

                if($title != '') {
                    $insert_data += ['art_title'=>$title];
                }

                if($alias != '') {
                    $insert_data += ['art_alias'=>$alias];
                }

                if($intro != '') {
                    $insert_data += ['art_intro'=>$intro];
                }

                if($image != '') {
                    $insert_data += ['art_image'=>$image];
                }

                if($date_post != '') {
                    $insert_data += ['art_date_post'=>GlobalController::convertDate($date_post)];
                }

                if($date_off != '') {
                    $insert_data += ['art_date_end'=>GlobalController::convertDate($date_off)];
                }

                if($author != '') {
                    $insert_data += ['art_created_by'=>$author];
                }

                if($hot != '') {
                    $insert_data += ['art_hot'=>$hot];
                }
                
                if($language != '') {
                    $insert_data += ['language'=>$language];
                }

            }

            //Nếu tồn tại dữ liệu thì thêm vào
            if(!empty($insert_data)) {
                $update     = $sql->update_or_create($insert_data, ['id' => NULL]);
                if($update) {
                    $post_id    = $sql->get_max_id();

                    //Thêm chi tiết articles
                    $this->addArticleDetail($post_id, $data);

                    $status     = GlobalController::$success;
                    $alert      = Config::get('constants.alert.updated');
                }
            }

        }

        return [
            'status'    => $status,
            'alert'     => $alert
        ];

    }
    
    
    /**
     * ADD ARTICLES DETAILS
     * -- Thêm chi tiết bài viết
     */
    public function addArticleDetail($post_id, $data) {

        $process   = [];

        GlobalController::set_table(self::$table_detail);
        GlobalController::set_fillable(['art_id', 'art_detail_name', 'art_detail_value']);
        $sql = new SQLDatabase;

        if(!empty($data)) {

            //Xóa dữ liệu cũ
            $sql->remove_data(['art_id' => $post_id]);
            foreach ($data as $key=>$items) {

                $update     = $sql->update_or_create([
                    'art_id'            => $post_id,
                    'art_detail_name'   => $key,
                    'art_detail_value'  => $items
                ], ['id' => NULL]);

                if($update) {
                    $process[]    = 'success';
                } else {
                    $process[]    = 'failed';
                }

            }

        }

        return $process;

    }

    //POST CREATE
    //UPDATE AND CREATE
    public function postUpdate(Request $request) {

        $status     = Config::get('constants.status.warning');
        $alert      = Config::get('constants.alert.not_update');
        $message    = [];
        $proccess   = [];

        //SET TABLE -- open fields table     

        $data = [];

        if($request->ajax()) {

            $data   = json_decode($request->data);

            //Get form_data
            $get_form_data      = GlobalController::form_get_data($data);
            $insert_condition   = $get_form_data['data']['get'];
            $insert_fillable    = $get_form_data['data']['fillable'];
            $insert_data        = $get_form_data['data']['data'];

            // echo '<pre>';
            // print_r($insert_data);
            // exit();

            //Thêm dữ chi tiết bài viết
            $proccessData     = $this->addArticle($insert_data);

        }

        return response()->json([
            'status'    => $proccessData['status'],
            'alert'     => TranslationController::translation($proccessData['alert']),
            'message'   => $message
        ]);

    }

}
