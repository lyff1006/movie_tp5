<?php 
namespace app\user\controller;
use app\user\model\UserModel;
use app\user\model\CollectModel;
use think\Controller;
use think\Db;
use think\Request;
header('Access-Control-Allow-Origin:http://school.weblyff.cn');  
header('Access-Control-Allow-Origin:http://localhost');  
// 响应类型  
header('Access-Control-Allow-Methods:*');  
// 响应头设置  
header('Access-Control-Allow-Headers:x-requested-with,content-type');
//cookie跨域
header('Access-Control-Allow-Credentials: true');

class Operate extends \think\Controller
{
	//电影收藏
	public function movieCollect(){
		$request=Request::instance()->param();
		$Collect=new CollectModel();
		/*$dbname="collect";
		$collectRequest=Db::name($dbname)->insert($request);*/
		$collectRequest=$Collect->save($request);
		if($collectRequest==1){
			return json(msg(1,"收藏成功",$collectRequest));
		}else{
			return json(msg(0,"收藏失败",$collectRequest));
		}
		
	}
	//获取用户电影收藏
	public function userCollect(){
		$request=Request::instance()->param();
		$dbname="collect";
		//dbname="user";
		//$userCollectRequest=Db::name($dbname)->alias("table_u")->join('movie_collect table_c','table_u.id=table_c.user_id')->where('id',$request['id'])->find();
		$userCollectRequest=Db::name($dbname)->where('user_id',$request['id'])->select();
		return json(msg(1,"获取成功",$userCollectRequest));
	}
	//删除电影收藏
	public function userDelCollect(){
		$request=Request::instance()->param();
		$dbname="collect";
		$dbrequest=Db::name($dbname)->delete($request['collect_id']);
		$newUserCollect=Db::name($dbname)->where('user_id',$request['id'])->select();
		return json(msg($dbrequest,"删除成功",$newUserCollect));
	}
	//用户留言
	public function userComment(){
		return "comment";
	}
	//获取用户信息
	public function userInfomation(){
		$dbname='user';
		@$request=Request::instance()->param();
		$userInfo=Db::table('movie_user')->where('id',$request['id'])->find();
		unset($userInfo['password']);
		$userCollectRequest=Db::name('collect')->where('user_id',$request['id'])->select();
		$userInfo['collect']=$userCollectRequest;
		return json(msg(1,'获取成功',$userInfo));
	}
	//编辑用户头像
	public function editUserHeadimg(){
		$dbname='user';
		$file = request()->file('file');
		$request=Request::instance()->param();
		$userId = $request['id'];
		// 移动到框架应用根目录/public/uploads/ 目录下
	    if($file){
	        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
	        if($info){ 
	            // 输出文件类型
	            //echo $info->getExtension();
	            // 输出目录名/文件名
	            $imgurl='http://www.weblyff.xyz/movie/public/uploads/'.$info->getSaveName();
	            // 输出文件名
	            //echo $info->getFilename(); 
	            $editRequest=Db::name($dbname)->where('id',$userId )->update(['head_img' => $imgurl]);
	            if($editRequest==1){
	            	return json(msg(1,"更换成功",$editRequest));
	            }else{
	            	return json(msg(0,"更换失败",$editRequest));
	            }
	            
	        }else{
	            // 上传失败获取错误信息
	            //echo $file->getError();
	            return json(msg(0,"更换失败",""));
	        }
	    }
	}
	//编辑用户信息
	public function editUserDetail(){
		$dbname='user';
		$request=Request::instance()->param();
		$userId=$request['id'];
		$updateKey=$request['key'];
		$updateData=$request['data'];
		$editRequest=Db::name($dbname)->where('id',$userId)->update([$updateKey=>$updateData]);
		if($editRequest==1){
			return json(msg(1,"更新成功",$editRequest));
		}else{
			return json(msg(1,"更新失败",$editRequest));
		}
	}
}
?>