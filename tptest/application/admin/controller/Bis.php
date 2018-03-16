<?php
namespace app\admin\controller;
use think\Controller;
class Bis extends  Controller
{
	private $obj;

	/**
	 * [初始化model]
	 * @return [type] [description]
	 */
	public function _initialize(){
		$this->obj = model('Bis');
	}

	/**
	 * [商户入驻列表]
	 * @return [type] [description]
	 */
	public function index(){

		$applyList = $this->obj->getstatusList(1);

		return $this->fetch('',[
			'applyList' => $applyList
		]);
	}

	/**
	 * [根据状态获取商户状态获取信息]
	 * @return [type] [description]
	 */
	public function apply() {
		$applyList = $this->obj->getStatusList();

		return $this->fetch('', [
			'applys' => $applyList,
		]);

	}

	public function detail() {
		$id = input('get.id');

		if(empty($id)){
			return $this->error();
		}

		//获取一级分类信息
		$City = model("City")->getCityList();
		//获取一级栏目分类
		$category = model("Category")->getNormalCategory();
		//获取商户基本信息
		$baseInfo = model('Bis')->get(['id'=>$id]);
		//获取总店信息
		$allInfo = model('BisLocation')->get(['bis_id'=>$id]);
		//查询账户信息
		$accInfo = model('BisAccount')->get(['bis_id'=>$id]);

		return $this->fetch('',[
			'City' => $City,
			'category' => $category,
			'baseInfo' => $baseInfo,
			'allInfo' => $allInfo,
			'accInfo' => $accInfo,
		]);
	}

	public function applyDel() {

		$applyDel = $this->obj->getstatusList(-1);

		return $this->fetch('',[
			'applyDel' => $applyDel
		]);
	}



	/**
	 * [状态更新]
	 * @return [type] [description]
	 */
	public function status() {
		$data = input('post.');
		//数据验证
		$validate = validate('Bis');
		if(!$validate->scene('status')->check($data)) {
			return $this->error($validate->getError());
		}

		//获取邮件地址
		$getEmail = $this->obj->get(['id'=>$data['id']]);
		//更改商户基本信息的审核状态
		$baseStatus = $this->obj->save(['status'=>$data['status']], ['id'=>$data['id']]);
		//更改总店信息的审核状态
		$allStatus = model('BisLocation')->save(['status'=>$data['status']], ['bis_id'=>$data['id']], ['is_main'=>1]);
		//更改账户信息的审核状态
		$accStatus = model('BisAccount')->save(['status'=>$data['status']], ['bis_id'=>$data['id']], ['is_main'=>1]);

		if($baseStatus && $allStatus && $accStatus){
			//发送邮件
			$url = request()->domain().url("bis/register/waiting", ['id'=>$data['id']]);

			$title = "TP5商城入驻申请状态通知";

			if($getEmail['status'] == 2){
				$content = "您提交的入驻申请被驳回，您可以通过点击链接<a href='".$url."' target='_blank'>查看链接</a> 查看审核状态";
			}elseif($getEmail['status'] == 1){
				$content = "您提交的入驻申请已审核成功，您可以通过点击链接<a href='".$url."' target='_blank'>查看链接</a> 查看审核状态";
			}elseif($getEmail['status'] == -1){
				$content = "您提交的入驻申请账户不存在或者严重违规，已被管理员删除，您可以通过点击链接<a href='".$url."' target='_blank'>查看链接</a> 查看审核状态";
			}elseif($getEmail['status'] == -1){
				$content = "您提交的入驻申请账户已恢复，您可以通过点击链接<a href='".$url."' target='_blank'>查看链接</a> 查看审核状态";
			}
			
			\phpmailer\Email::send($getEmail['email'],$title,$content);

			$this->success('状态更新成功!邮件已发送');
		}else{
			$this->error('状态更新失败!');
		}
	}
}