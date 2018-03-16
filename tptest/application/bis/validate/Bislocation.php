<?php
namespace app\bis\validate;
use think\Validate;
class Bislocation extends Validate
{
	protected $rule = [
		'name' => 'require|max:25',
		'address' => 'require',
		'contact' => 'require',
		'open_time' => 'require',
	];

	protected $scene = [
		'add' => ['name','address','contact','open_time'],
	];
}