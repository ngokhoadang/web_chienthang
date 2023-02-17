<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Web_config extends Model
{
    protected $table ='web_configs';
	
	//Get data
	public function get_data($type='first', $condition='', $select='*', $limit='') {
	
		$data = ['data'];
		
		$query = self::select($select);
		
		if($condition != '') {
			$query->where($condition);
		}
		
		switch ($type) {
			
			case 'get':
				$data = $query->get();
				break;
			default:
				$data = $query->first();
				break;
			
		}
		
		return $data;
		
	}
	
}
