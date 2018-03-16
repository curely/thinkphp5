<?php
//公共show方法
function show($status,$message='',$data=[]){
	return [
		'status' => intval($status),
		'message' => $message,
		'data' => $data,
	];
}
