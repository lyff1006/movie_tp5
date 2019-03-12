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
/**
 * 统一返回信息
 * @param $code
 * @param $data
 * @param $msge
 */
use think\Db;
function msg($code, $msg ,$data)
{
    return compact('code', 'msg', 'data');
}
//密码的Md5加密
function passwordMd5($value)
{
    return MD5($value);
}
//获取随机数，$e是随机数的长度
function getrand($e){
	$str="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $key = "";
    for($i=0;$i<$e;$i++)
	{
		$key .= $str{mt_rand(0,61)};    //生成php随机数
	}
    return $key;
}
function page($dbname,$eachpage,$searchname='',$searchdata=''){
	if($searchname!=''&&$searchdata!=''){
		$where[$searchname]=['like','%'.$searchdata.'%'];
		$list1 = Db::name($dbname)->where($where)->paginate($eachpage)->items();
	}else{
		$list1 = Db::name($dbname)->paginate($eachpage)->items();
	}
    return ($list1);
}
