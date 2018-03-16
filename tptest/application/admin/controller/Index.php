<?php
namespace app\admin\controller;
use think\Controller;

class Index extends Controller
{
    public function index()
    {	
        return $this->fetch();
    }

    public function welcome(){
        
        //return '发送邮件成功';
        return $this->fetch();
    }

    public function test(){
        // $dz = "1208226728@qq.com";
        // $bt = "狗子";
        // $nr = "刘狗子";
        // \phpmailer\Email::send($dz,$bt,$nr);
        // return "发送成功!";
        // return \Map::getLngLat("江西省南昌市高新南大道");  
    }

    public function map(){
        return \Map::getImage("江西省南昌市高新地铁站");
    }
}