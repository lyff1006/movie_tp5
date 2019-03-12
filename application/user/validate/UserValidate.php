<?php
// +----------------------------------------------------------------------
// | snake
// +----------------------------------------------------------------------
// | Copyright (c) 2016~2022 http://baiyf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: NickBai <1902822973@qq.com>
// +----------------------------------------------------------------------
namespace app\user\validate;

use think\Validate;

class UserValidate extends Validate
{
    /*protected $rule = [
	    'role_name'   => 'require|max:20',
	    'account'     => 'email|unique:user',
	    'password'    => 'require',
	];
	protected $message = [
	    'role_name.require'  => '缺少用户名',
	    'role_name.max'      => '用户名不能超过25个字符',
	    'password.require'   => '缺少密码',
	    'account.unique'     => '账号已存在',
	    'account.email'      => '账号格式错误',
	];
	protected $scene = [
		'edit'  =>  ['role_name'],
    ];*/
    protected $rule=[
    	['role_name', 'require', '用户名不能为空'],
    	['role_name', 'max:25', '用户名不能超过25个字符'],
	    ['account', 'email', '账号格式错误空'],
	    ['id', 'unique:user', 'id已存在'],
	    ['account', 'unique:user', '账号已存在'],
	    ['password', 'require', '密码不能为空']
    ];
}