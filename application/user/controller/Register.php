<?php
namespace app\user\controller;
use app\user\model\UserModel;
use think\Controller;
use org\Verify;
use think\Db;
use think\Request;
use think\Cache;
header('Access-Control-Allow-Origin:*');  
// 响应类型  
header('Access-Control-Allow-Methods:*');  
// 响应头设置  
header('Access-Control-Allow-Headers:x-requested-with,content-type');
class Register extends \think\Controller
{
    public function hello($name="world",$city="")
    {
    	return 'hello,'.$name.'!you come from '.$city;
    }
    //注册
    public function doRegister()
    {
        $request=Request::instance()->param();
        $CacheCode=Cache::get($request['account']);//从缓存中读取对应的验证码
        if (strtolower($request['code'])==strtolower($CacheCode)) {
            unset($request['code']);
            $request['id']=getrand(32);
            $request['password']=md5($request['password'] . config('salt'));
            /*$request['id']=getrand(32);
            $request['account']="2333333333333@qq.com";
            $request['password']='admin2';
            $request['password']=md5($request['password'] . config('salt'));
            $request['role_name']='role_name';*/
            $user = new UserModel();
            $flag = $user->insertUser($request);
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }else{
            return json(msg(0,'验证码错误',$CacheCode));
        } 	
    }
    
}