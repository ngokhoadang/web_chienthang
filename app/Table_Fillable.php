<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\GlobalSQLCondition;

class Table_Fillable extends Model
{
    
    protected $table    = 'fillable';
    protected $fillable = ['table_name', 'table_fillable', 'table_get'];

    /**
     * GET LIST
     */
    public function get_data($type='get', $condition='', $select='*', $limit='', $order_by='', $join='') {

        $result = [];

        $query = self::select($select);

        $query  = GlobalSQLCondition::setCondition($query, $condition);

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
    public function update_data($table_name, $data) {

        $result = false;

        $condition  = [
            'table_name'    => $table_name
        ];

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
