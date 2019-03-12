<?php  
namespace app\user\controller;
header('Access-Control-Allow-Origin:http://school.weblyff.cn');  
header('Access-Control-Allow-Origin:http://localhost');  
// 响应类型  
header('Access-Control-Allow-Methods:*');  
// 响应头设置  
header('Access-Control-Allow-Headers:x-requested-with,content-type');
//cookie跨域
header('Access-Control-Allow-Credentials: true');

class File extends \think\Controller
{
	public function upload()
	{
		$file = request()->file('file');
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
	            return $imgurl;
	        }else{
	            // 上传失败获取错误信息
	            //echo $file->getError();
	            return "error";
	        }
	    }
	}
}
?>