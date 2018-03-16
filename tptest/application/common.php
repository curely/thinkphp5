<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
//状态修改
function status($status){
    if($status == 1){
        $str = '<button class="layui-btn">正常</button>';
    }elseif($status == 0){
        $str = '<button class="layui-btn layui-btn-warm">待审</button>';
    }else{
        $str = '<button class="layui-btn layui-btn-danger">已删除</button>';
    }
    return $str;
}

/**
 * [curl description]
 * @param  [type] $url  [description]
 * @param  [type] $type [0 get 1 post]
 * @param  array  $data [description]
 * @return [type]       [description]
 */
function doCurl($url, $type=0, $data=[]) {
    $ch = curl_init(); // 初始化
    // 设置选项
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER,0);

    if($type == 1) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }

    //执行并获取内容
    $output = curl_exec($ch);
    // 释放curl句柄
    curl_close($ch);
    return $output;
}

/**
 * [审核状态通知]
 * @param  [type] $status [状态码]
 * @return [type]         [description]
 */
function BisWaiting($status){
    if($status == 1) {
        $str = "入驻申请成功!";
    }elseif($status == 0){
        $str = "待审核，平台审核通过后，将会下发邮件通知，请关注邮件!";
    }elseif($status == 2){
        $str = "非常抱歉，你提交的材料不符合条件，请重新提交!";
    }else{
        $str = "申请资料不合法，已删除!";
    }

    return $str;
}

/**
 * [分页]
 * @param  [type] $obj [对象数据]
 * @return [type]      [description]
 */
function pagination($obj) {
    if(!$obj){
        return '';
    }

    return '<div class="page ">'.$obj->render().'</div>';
}

/**
 * [获取二级城市名称]
 * @param  [type] $path [城市路径]
 * @return [type]       [description]
 */
function getCityName($path) {
    if(empty($path)){
        return '';
    }

    if(preg_match('/,/', $path)){
        $cityPath = explode(',', $path);
        $newPath = $cityPath[1];
    }else{
        $newPath = $path;
    }

    $cityName = model('city')->get($newPath);
    
    return $cityName->name;
}