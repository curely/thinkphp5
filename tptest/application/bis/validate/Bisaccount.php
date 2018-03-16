<?php
namespace app\bis\validate;
use think\Validate;
class Bisaccount extends Validate
{
	protected $rule = [
		'username' => 'require|max:25',
		'password' => 'require',
	];

	protected $scene = [
		'add' => ['username','password'],
	];
}