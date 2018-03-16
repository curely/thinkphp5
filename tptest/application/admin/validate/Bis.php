<?php
namespace app\admin\validate;
use think\Validate;

class Bis extends Validate
{
	protected $rule = [
		['id','number'],
		['status','number'],
	];

	protected $scene = [
		'status' => ['id','status'],
	];
}