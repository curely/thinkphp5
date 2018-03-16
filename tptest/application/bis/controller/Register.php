<?php
namespace app\bis\controller;
use think\Controller;
class Register extends Controller
{
	public function index(){
		//获取城市一级分类
		$result = model("City")->getCityList();
		//获取一级栏目分类
		$category = model("Category")->getNormalCategory();
		
		return $this->fetch('',[
			'city' => $result, 
			'category' => $category,
		]);
	}

	public function add(){
		if(!request()->isPost()){
			$this->error("请求错误!");
		}
		//获取表单的值
		$data = input("post.");
		//检验数据
		$validate = validate("Bis");
		if(!$validate->scene("add")->check($data)){
			$this->error($validate->getError());
		}

		//获取经纬度
		$lnglat = \Map::getLngLat($data['address']);
		//检验经纬度是否准确
		if(empty($lnglat) || $lnglat['status'] !=0 || $lnglat['result']['precise'] !=1){
			$this->error("无法获取数据 或者地址不精准");
		}

		try{
			//商户基本信息入库
			$bisData = [
				'name' => $data['name'],
				'email' => $data['email'],
				'logo' => $data['logo'],
				'licence_logo' => $data['licence_logo'],
				'description' => $data['description'],
				'city_id' => $data['city_id'],
				'city_path' => empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'].','.$data['se_city_id'],  
				'bank_info' => $data['bank_info'],
				'bank_name' => $data['bank_name'],
				'bank_user' => $data['bank_user'],
				'corpor' => $data['faren'],
				'corpor_tel' => $data['faren_tel'],
			];

			//数据入库
			$BisId = model("Bis")->add($bisData);
			
		  	//总店相关信息检验
			// $bisVali = validate("BisLocation");
			// if(!$bisVali->scene("add")->check($data)){
			// 	$this->error($bisVali->getError());
			// }
			//把子分类信息用|拼接
			$data['cat'] = '';
			if(!empty($data['se_category_id'])){
				$data['cat'] = inplode('|',$data['se_category_id']);
			}
			//总店信息入库
			$locationData = [
				'bis_id' => $BisId,
				'name' => $data['name'],
				'logo' => $data['logo'],
				'address' => $data['address'],
				'api_address' => $data['address'],
				'tel' => $data['tel'],
				'contact' => $data['contact'],
				'city_id' => $data['city_id'],
				'city_path' => empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'].','.$data['se_city_id'],
				'category_id' => $data['category_id'],
				'category_path' => $data['category_id'].','.$data['cat'],
				'open_time' => $data['open_time'],
				'content' => $data['content'],
				'is_main' => 1,//代表总店
				'xpoint' => empty($lnglat['result']['location']['lng']) ? '' : $lnglat['result']['location']['lng'],
				'ypoint' => empty($lnglat['result']['location']['lat']) ? '' : $lnglat['result']['location']['lat'],
			];

			$locationId = model("BisLocation")->add($locationData);

			//账户相关信息检验
			$accVali = validate("BisAccount");
			if(!$accVali->scene("add")->check($data)){
				$this->error($accVali->getError());
			}

			//密码加密 加盐处理
			$data['code'] = mt_rand(100,10000);
			$accountData = [
				'bis_id' => $BisId,
				'username' => $data['username'],
				'password' =>  md5($data['password'].$data['code']),
				'code' => $data['code'],
				'is_main' => 1,
			];

			$accountId = model("BisAccount")->add($accountData);
			if(!$accountId){
				return $this->error("申请失败!");
			}
		}catch(Exception $e){
			$this->error($e->getError());
			// echo 'Message: ' .$e->getMessage();
		}

		//sendmail
		$url = request()->domain().url("bis/register/waiting", ['id'=>$BisId]);
		$title = "TP5商城入驻申请通知";
		$content = "您提交的入驻申请需等待平台方审核，您可以通过点击链接<a href='".$url."' target='_blank'>查看链接</a> 查看审核状态";
		\phpmailer\Email::send($data['email'],$title,$content);

		$this->success('申请成功!',url('Register/waiting',['id'=>$BisId]));
	}

	//商户审核状态
	public function waiting($id){
		if(empty($id)){
			$this->errorr('error');
		}

		$detail = Model("Bis")->get($id);

		return $this->fetch("",[
			"detail" => $detail,
		]);
	}

	//ajax获取地图标注
	public function getMap(){
		//获取前段提交的地址
		$address = input("post.address");
		//通过百度api获取标注
		$mapImg = \Map::getImage($address);
	}

	//检测用户名是否注册
	public function Info(){
		$name = input("post.name");

		$nameGt = Model('bis')->get(['name'=>$name]);
		
		if($nameGt){
			return $this->error("用户名存在，请更换!");
		}
	}

}