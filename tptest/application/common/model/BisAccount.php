<?php
namespace app\common\model;

use think\Model;

class BisAccount extends BaseModel
{
	public function updateLogin($data = array(), $id) {
		return $this->allowField(true)->save($data,['id'=>$id]);
	}
}