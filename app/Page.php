<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    
    protected $table    = 'pages';
    protected $fillable = ['page_title', 'page_modules', 'page_pages', 'page_keyword', 'page_type', 'page_status'];

    public function get_max_id() {
        $max_id = self::max('id');
        return $max_id;
    }
    
    public function update_or_create() {

        $result = false;

        $update = self::updateOrCreate($condition,$data);

        if($update) $result = true;

        return $result;

    }

}
