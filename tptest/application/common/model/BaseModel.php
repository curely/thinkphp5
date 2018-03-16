<?php
/**
 * 公共函数
 */
namespace app\common\model;

use think\Model;

class BaseModel extends Model
{
	//自动添加时间
	protected $autoWriteTimestamp = true;
	public function add($data){
		$data['status'] = 0;
		$this->save($data);
		return $this->id;
	}
}