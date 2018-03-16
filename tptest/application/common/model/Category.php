<?php
namespace app\common\model;
use think\Model;
class Category extends Model
{
	//分类增加
	protected $autoWriteTimestamp = true;//自动增加时间
	public function add($data){
		//定义字段值
		$data['status'] = 1;
		// $data['create_time'] = time();
		//返回数据
		return $this->save($data);
	}	

	//添加页面获取顶级分类
	public function getList(){
		$data =[
			'parent_id' => 0,
			'status' => 1,
		];

		$order = [
			'id' => 'desc',
		];

		return $this->where($data)->order($order)->select();
	}

	//首页获取点击分类
	public function getFirstlist($parentId = 0){
		$data = [
			'parent_id' => $parentId,
			'status' => ['neq',-1]
		];
		$order = [
			'listorder' => 'desc',
			'id' => 'desc',
		];
		return $this->where($data)->order($order)->paginate(20);
	}

	//获取分类
	public function getNormalCategory($parentId = 0){
		$data = [
			'status' => 1,
			'parent_id' => $parentId,
		];

		$order = [
			'listorder' => 'desc'
		];

		return $this->where($data)->order($order)->select();
	}


}