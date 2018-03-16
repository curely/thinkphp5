<?php
namespace app\api\controller;
use think\Controller;
class Category extends Controller
{
	private $obj;
	//初始化对象
	public function _initialize(){
		$this->obj = model("Category");
	}
	public function getChildCate(){
		$id = input("post.id",0,'intval');
		if(!$id){
			$this->error("id不合法");
		}
		//通过id获取二级栏目
		$cate = $this->obj->getNormalCategory($id);
		if(!$cate){
			return show(0,'error');
		}
		return show(1,'success',$cate);
	}
}