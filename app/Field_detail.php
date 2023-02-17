<?php

namespace App;

use App\Http\Controllers\GlobalController;

use Illuminate\Database\Eloquent\Model;

class Field_detail extends Model
{
    
    protected $table;
    protected $fillable;

    public function __construct() {
        $this->table    = GlobalController::get_table();
        $this->fillable = GlobalController::get_fillable();
    }

    /**
     * GET MAX ID
     */
    public function get_max_id() {
        return self::max('id');
    }

    /**
     * CHECK DUPLICATE
     */
    public function check_duplicate($condition, $select='*') {

        $query  = self::select($select);

        if($condition != '') {

            $issetWhere     = false;
            $issetWhereIn   = false;

            //Nếu điều kiện dạng mở rộng
            if(isset($condition['where']) && $condition['where'] != '') {
                $query->where($condition['where']);
                $issetWhere     = true;
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

            if($issetWhere == false && $issetWhereIn == false) {
                $query->where($condition);
            }

        }

        return $query->count();

    }


    /**
     * GET LIST
     */
    public function get_data($type='get', $condition='', $column='', $start_date='', $end_date='', $select='*', $limit='', $order_by='', $join='') {

        $result = [];

        $query = self::select($select);

        if($condition != '') {

            $issetWhere     = false;
            $issetWhereIn   = false;

            //Nếu điều kiện dạng mở rộng
            if(isset($condition['where']) && $condition['where'] != '') {
                $query->where($condition['where']);
                $issetWhere     = true;
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

            if($issetWhere == false && $issetWhereIn == false) {
                $query->where($condition);
            }

        }

        if($start_date != '' && $end_date != '') {
            $query->whereBetween($column, [$start_date, $end_date]);
        }

        if($limit != '') {
            $query->skip($limit[0])->take($limit[1]);
        }

        switch ($type) {
            case 'count':
                $result = $query->count();
                break;
            case 'sum':
                $result = $query->sum($select);
                break;
            case 'get':
                $result = $query->get();
                break;
            default:
                $result = $query->first();
                break;
        }

        return $result;

    }

    /**
     * CREATE DATA
     */
    public function create_data($data) {

        $result = false;

        $create = self::create($data);

        if($create) $result = true;

        return $result;

    }

    /**
     * UPDATE OR CREATE
     */
    public function update_or_create($data, $condition) {

        $result = false;

        $update = self::updateOrCreate($condition, $data);

        if($update) $result = true;

        return $result;

    }

    /**
     * REMOVE DATA
     */
    public function remove_data($condition) {

        $result = false;

        $remove = self::where($condition)->delete();

        if($remove) $result = true;

        return $result;

    }

}
