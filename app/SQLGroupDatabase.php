<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Http\Controllers\GlobalController;

class SQLGroupDatabase extends Model
{
    
    protected $table    = 'field_groups';
    protected $fillable = ['fdetail_id', 'fieldgroup_item', 'fieldgroup_value', 'fieldgroup_type', 'fieldgroup_select'];

    // public function __construct() {
    //     $this->table    = GlobalController::get_table();
    //     $this->fillable = GlobalController::get_fillable();
    // }

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
