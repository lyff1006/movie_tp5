<?php
namespace app\user\controller;
use app\user\model\UserModel;
use think\Controller;
use org\Verify;
use think\Db;
use think\captcha\Captcha;
use think\Request;
use think\Cache;
header('Access-Control-Allow-Origin:http://school.weblyff.cn');  
header('Access-Control-Allow-Origin:http://localhost');  
// 响应类型  
header('Access-Control-Allow-Methods:*');  
// 响应头设置  
header('Access-Control-Allow-Headers:x-requested-with,content-type');
//cookie跨域
header('Access-Control-Allow-Credentials: true');


class Login extends \think\Controller
{
    //登录
    public function doLogin()
    {
        @$request = Request::instance()->param();
    	$account = $request['account'];//input("param.user_name");
        $password = $request['password'];//input("param.password");
        $code=$request['code'];
        if(!captcha_check($code)){
            return json(msg(0,'验证失败',''));
        }else{
            $userModel = new UserModel();
            $hasUser = $userModel->checkUser($account);
            if(empty($hasUser)){
                return json(msg(0, '用户不存在',''));
            }
            if(md5($password . config('salt')) != $hasUser['password']){
                return json(msg(0,'密码错误',''));
            }
            if($hasUser['status']!=1){
                return json(msg(0,'账号异常',''));
            }
            /*if($password != $hasUser['password']){
                return json(msg(-4,'密码错误',''));
            }*/
            session('account', $hasUser['account']); //账号
            session('id', $hasUser['id']); 
            session('head_img', $hasUser['head_img']); //头像
            session('role_name', $hasUser['role_name']);  // 角色名
            //$result1=Db::name('user')->where('password', 'admin')->update(['password' => passwordMd5($password)]);
            $userId['id']=$hasUser['id'];
            $userId['account']=$hasUser['account'];
            $userId['head_img']=$hasUser['head_img'];
            $userId['role_name']=$hasUser['role_name'];
            return json(msg(1,'登录成功',$userId));
        };
    }
    // 验证码
    public function getVerify()
    {
        ob_clean();
        $captcha = new Captcha();
        $captcha->length=4;
        $captcha->fontSize=28;
        //$captcha->useZh=true;
        return $captcha->entry();
    }
    //验证码验证
    public function checkVerify()
    {
        $request = Request::instance()->param();
        if(!captcha_check($request['code'])){
            return json(msg(0,'验证失败',''));
        }else{
            return json(msg(1,'验证成功',''));
        };
    }
    //获取所有用户信息
    public function getalluser(){
        @$request = Request::instance()->param();
        $dbname='user';
        if(@$request['eachpage']!=''){
            $eachpage=$request['eachpage'];
        }else{
            $eachpage=10;
        }
        @$searchname=$request['searchname'];
        @$searchdata=$request['searchdata'];
        //return $searchname.$searchdata;
        $result=page($dbname,$eachpage,$searchname,$searchdata);
        return json(msg(1,'用户信息',$result));
    }
}