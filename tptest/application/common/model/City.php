<?php

namespace app\Common\model;

use think\Model;

class City extends Model
{
    public function getCityList($parentId = 0){
    	$data = [
    		'status' => 1,
    		'parent_id' => $parentId,
    	];

    	$order = [
    		'id' => 'asc',
    	];

    	return $this->where($data)->order($order)->select();
    }
}
