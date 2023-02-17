<?php

namespace App;

use App\Http\Controllers\GlobalController;
use App\Http\Controllers\GlobalSQLCondition;

use Illuminate\Database\Eloquent\Model;

class SQLDatabase extends Model
{
    
    protected $table;
    protected $fillable;

    public function __construct() {
        new GlobalController;
        new GlobalSQLCondition;
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
     * TĂNG GIÁ TRỊ LÊN 1 CỦA 1 CỘT NÀO ĐÓ
     * LOẠI: CỘT ĐÓ PHẢI CÓ GIÁ TRỊ LÀ INT
     */
    public function incrementInt($condition, $column) {

        $result = false;

        $update = self::where($condition)->increment($column);

        if($update) $result = true;

        return $result;

    }

    /**
     * CHECK DUPLICATE
     */
    public function check_duplicate($condition, $select='*') {

        $query  = self::select($select);

        $query  = GlobalSQLCondition::setCondition($query, $condition);

        return $query->count();

    }


    /**
     * GET LIST
     */
    public function get_data($type='get', $condition='', $select='*', $limit='', $order_by='', $join='') {

        $result = [];

        $query = self::select($select);

        $query  = GlobalSQLCondition::setCondition($query, $condition);

        if($order_by != '') {
            $query->orderByRaw($order_by);
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
    public function update_data($data, $condition) {

        $result = false;

        $update = self::where($condition)->update($data);

        if($update) $result = true;

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
