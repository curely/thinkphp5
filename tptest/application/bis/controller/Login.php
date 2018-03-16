<?php
namespace app\bis\controller;
use think\Controller;
class Login extends Controller
{
	public function index(){
		
		if(request()->isPost()) {
			
			$data = input('post.');

			$name = htmlspecialchars($data['name']);
			//通过用户名获取用户信息
			$userInfo = model('BisAccount')->get(['username'=>$name]);
			//判断用户是否审核通过
			if(!$userInfo || $userInfo->status !=1) {
				$this->error('该用户不存在，或者该用户未审核!');
			}
			//判断用户密码是否正确
			if($userInfo->password != md5($data['password'].$userInfo->code)) {
				$this->error('密码错误!');
			}
			//写入用户最后登录时间和ip
			$ip = $_SERVER["SERVER_ADDR"];
			$data = [
				'last_login_time' => time(),
				'last_login_ip' => $ip,
			];
			model('BisAccount')->updateLogin($data,$userInfo->id);
			//把用户信息存入session
			session('name', $userInfo, 'bis');

			return $this->success('登录成功!',url('index/index'));
		}else{
			$account = session('name', '', 'bid');
			//如果存在session账号和id 直接跳转首页
			if($account && $account->$id){
				$this->redirect(url('index/index'));
			}
			return $this->fetch();
		}
	}

	
}