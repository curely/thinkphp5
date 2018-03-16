<?php
namespace app\common\model;

use think\Model;

class Bis extends BaseModel
{	
	/**
	 * [根据状态获取商户入驻信息]
	 * @param  integer $status [状态]
	 * @return [type]          [description]
	 */
	public function getStatusList($status = 0) {
		$order = [
			'id' => 'desc',
		];

		$data = [
			'status' => $status,
		];

		$result = $this->where($data)->order($order)->paginate(10);

		return $result;
	}
}