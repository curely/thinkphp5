<?php
namespace app\api\controller;
use think\Controller;
class City extends Controller
{
	private $obj;

	//初始化对象
	public function _initialize(){
		$this->obj = model("City");
	}

	public function getChildCitys(){
		$id = input("post.id");
		if(!$id){
			$this->error("id不合法");
		}

		$city = $this->obj->getCityList($id);
		if(!$city){
			return show(0,'error');
		}
		return show(1,'success', $city);
	}
	
}