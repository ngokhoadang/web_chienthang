<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Http\Controllers\GlobalSQLCondition;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_id', 'name', 'email', 'password', 'api_token', 'phone', 'full_name', 'sex', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * GET MAX ID
     */
    public function get_max_id() {
        return self::max('id');
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
     * CHECK DUPLICATE
     */
    public function check_duplicate($condition, $select='*') {

        $result = false;
        
        $query  = self::select($select);

        $query  = GlobalSQLCondition::setCondition($query, $condition);

        if($query->count() > 0) {
            $result = true;
        }

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

    public function update_data($data, $condition) {

        $result = false;

        $update = self::where($condition)->update($data);

        if($update) $result = true;

        return $result;
    }

}
