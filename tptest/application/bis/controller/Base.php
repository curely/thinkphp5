<?php
namespace app\bis\controller;
use think\Controller;
class Base extends Controller
{
	public $account;

	public function _initialize() {
		$retu = $this->isLogin();
		if(!$retu){
			return $this->redirect(url('login/index'));
		}
	}

	public function isLogin() {
		//获取session里的值
		$info = $this->getUserInfo();
		if($info && $info->id){
			return true;
		}
		return false;
	}

	public function getUserInfo() {
		if(!$this->account){
			$this->account = session('name', '', 'bis');
		}
		return $this->account;
	}
}