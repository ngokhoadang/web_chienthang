<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission_detail extends Model
{
    protected $table    = 'permission_details';
    protected $fillable = [
        'user_id', 'perdetail_modules', 'perdetail_permission', 'perdetail_type', 'perdetail_sort', 'perdetail_status'
    ];

    /**
     * UPDATE OR CREATE
     */
    public function update_or_create($data, $condition) {

        $result = false;

        $update = self::updateOrCreate($condition, $data);

        if($update) $result = true;

        return $result;

    }

}
