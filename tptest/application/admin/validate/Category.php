<?php
namespace app\admin\validate;
use think\Validate;

class Category extends Validate
{
	//简化版本
	/*
	*	protected $rule 	= [
			['name','require|max:20','分类名不能为空|分类名最多不超过20个字符'],
		],
	*/
	//规则
	protected $rule 	= [
		['id','number'],
		['name','require|max:20', '分类名不能为空|分类名最多不超过20个字符'],
		['parent_id','number'],
		['status','number|in:-1,0,1', '状态必须是数字|状态范围不合法'],
		['listorder','number'],
	];

	//信息
	// protected $message 	= [
	// 	'id.number'		=> 'id必须是数字',
	// 	'name.require' 	=> '分类名不能为空',
	// 	'name.max' 		=> '分类名最多不超过20个字符',
	// 	'parent_id.number'		=> '父id必须是数字',
	// 	'status.number'	=> '状态必须是数字',
	// 	'status.int' 	=> '状态范围不合法',
	// 	'listorder.number'		=> '排序必须为数字',
	// ],

	//场景设置
	protected $scene	= [
		'add'	=> ['name','parent_id','id'],//添加
		'listorder'	=> ['id','listorder'],//排序
		'status' => ['id','status'],//修改状态
	];
}