<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GlobalSQLCondition extends Controller
{

    public static function setCondition($query, $condition='') {

        if($condition != '') {

            $issetWhere         = false;
            $issetWhereIn       = false;
            $issetWhereSearch   = false;

            //Nếu điều kiện dạng mở rộng
            if(isset($condition['where']) && $condition['where'] != '') {
                $query->where($condition['where']);
                if(isset($condition['orWhere']) && $condition['orWhere'] != '') {
                    $orWhere    = $condition['orWhere'];
                    $query->orWhere(function($query) use ($orWhere) {
                        $query->where($orWhere);
                    });
                }
                $issetWhere     = true;
            }

            //Nếu tồn tại Keysearch
            if(isset($condition['keySearch']) && $condition['keySearch'] != '') {
                $keySearch          = $condition['keySearch'];
                $keySearchValue     = isset($keySearch[0]) ? $keySearch[0] : '';
                $keySearchColumn    = isset($keySearch[1]) ? $keySearch[1] : []; //Is array
                if($keySearchValue != '' && !empty($keySearchColumn)) {
                    foreach ($keySearchColumn as $key=>$cond_items) {
                        if($key == 0) {
                            $query->where($cond_items,'LIKE', '%'.$keySearchValue.'%');
                        } else {
                            $query->orWhere($cond_items,'LIKE','%'.$keySearchValue.'%');
                        }
                    }
                }
                $issetWhereSearch = true;
            }

            //Điều kiện whereIn
            if(isset($condition['whereIn'])) {
                $whereIn    = $condition['whereIn'];
                if(count($whereIn) > 0) {
                    foreach ($whereIn as $key=>$con_items) {
                        $query->whereIn($key, $con_items);
                    }
                } else {
                    $query->whereIn(array_keys($whereIn)[0], array_values($whereIn)[0]);
                }
                $issetWhereIn   = true;
            }

            if(isset($condition['whereNotIn'])) {
                $whereIn    = $condition['whereNotIn'];
                $query->whereNotIn(array_keys($whereIn)[0], array_values($whereIn)[0]);
                $issetWhereIn   = true; //Lấy để kiểm tra nếu tồn tại điều kiện
            }

            //Điều kiện whereBetween
            if(isset($condition['whereBetween']) && $condition['whereBetween'] != '') {
                $whereBetween    = $condition['whereBetween'];
                $query->whereBetween(array_keys($whereBetween)[0], array_values($whereBetween)[0]);
                $whereBetween   = true;
            }

            if($issetWhere == false && $issetWhereIn == false && $issetWhereSearch == false) {
                $query->where($condition);
            }

        }

        return $query;

    }


}
