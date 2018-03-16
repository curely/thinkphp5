<?php
namespace app\admin\controller;
use think\Controller;

class Category extends Controller
{
	private $obj;
	//初始化对象
	public function _initialize(){
		$this->obj = model("Category");
	}
	
	public function index(){
		//首页的分类
		$parentId = input('get.parent_id',0,'intval');

		$first = $this->obj->getFirstlist($parentId);
		//添加页面的分类
		$res = $this->obj->getList();
		
		return $this->fetch('',[
			'res' => $res,
			'first' => $first,
		]);
	}

	//保存数据
	public function save(){
		//严格校验
		if(!request()->isPost()){
			$this->error("请求失败!");
		}	
		$data = input("post.");
		//数据验证(助手函数)
		$validate = validate("Category");
		if(!$validate->scene("add")->check($data)){
			return $this->error($validate->getError());
		}
		if(!empty($data['id'])){
			return $this->obj->update($data);
		}
		//把数据提交给model,保存数据
		$result = $this->obj->add($data);
		if($result){
			$this->success("新增成功!");
		}else{
			$this->error("新增失败!");
		}
	}

	//编辑数据
	public function edit($id = 0){
		if(intval($id)<0){
			$this->error("参数不合法");
		}
		//根据id获取数据
		$category = $this->obj->get($id);
		$cateChild = $this->obj->getList();
		return $this->fetch('',[
			'category' => $category,
			'cateChild' => $cateChild,
		]);
	}

	//更新操作
	public function update($data){
		$res = $this->obj->save($data,['id'=>$data['id']]);
		if($res){
			$this->success("保存成功!");
		}else{
			$this->error("保存失败!");
		}
	}

	//排序
	public function listorder($id,$listorder){
		$res = $this->obj->save(['listorder'=>$listorder],['id'=>$id]);
		if($res){
			$this->result($_SERVER['HTTP_REFERER'],1,'修改成功!');
		}else{
			$this->result($_SERVER['HTTP_REFERER'],0,'修改失败!');
		}
	}

	//修改状态
	public function status(){
		$data = input("get.");
		$validate = validate("Category");
		if(!$validate->scene("status")->check($data)){
			return $this->error($validate->getError());
		}

		//更改数据
		$res = $this->obj->save(['status'=>$data['status']],['id'=>$data['id']]);
		if($res){
			$this->success("修改成功!");
		}else{
			$this->error("修改失败!");
		}
	}

	//批量删除
	public function delAll(){
		//获取id
		$data = input("post.");
		//把 6,7,8,样式的字串改成6,7,8
		$newId = substr($data['id'],0,strlen($data['id'])-1);
		//批量更新
		$res = $this->obj->where("id IN($newId)")->update(['status'=>-1]);
		if($res){
			$this->success("删除成功!");
		}else{
			$this->error("删除失败!");
		}
	}

}