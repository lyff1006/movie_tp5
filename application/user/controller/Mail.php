<?php 
namespace app\user\controller;
use think\Controller;
use PHPMailer\PHPMailer\PHPMailer;
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



class Mail extends \think\Controller
{
	public function doSend()
	{
		 //实例化
        $mail=new PHPMailer();
        $request = Request::instance()->param();
        
        try{
        	//发件人邮箱
        	$SendMail='3327657836@qq.com';
        	//发件人名字
        	$SendName='电影平台管理员';
        	//收件人邮箱
        	$ReceiveMail=$request['mail'];
        	//收件人名字
            $ReceiveName=@$request['name'];
        	//邮件主题
        	$MailTitle='电影平台注册验证码';
        	//邮件正文
        	$code=getrand(6);
        	$MailBody='尊敬的'.$ReceiveName.'用户,您的电影平台注册验证码为：'.$code;
            /*if(@$request['name']!=null){
                
            }*/



            //邮件调试模式
            $mail->SMTPDebug = false;  
            //设置邮件使用SMTP
            $mail->isSMTP();
            // 设置邮件程序以使用SMTP
            $mail->Host = 'smtp.qq.com';
            // 设置邮件内容的编码
            $mail->CharSet='UTF-8';
            // 启用SMTP验证
            $mail->SMTPAuth = true;
            // SMTP username
            $mail->Username = '3327657836@qq.com';
            // SMTP password
            $mail->Password = 'qtxbdmzgcqhmcjcc';
            // 启用TLS加密，`ssl`也被接受
//            $mail->SMTPSecure = 'tls';
            // 连接的TCP端口
//            $mail->Port = 587;
            //设置发件人
            $mail->setFrom($SendMail, $SendName);

           //  添加收件人1
            $mail->addAddress($ReceiveMail,$ReceiveName);     // Add a recipient
//            $mail->addAddress('ellen@example.com');               // Name is optional

//            收件人回复的邮箱
            $mail->addReplyTo($SendMail, $SendName);

//            抄送
//            $mail->addCC('cc@example.com');
//            $mail->addBCC('bcc@example.com');

            //附件
//            $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content
            // 将电子邮件格式设置为HTML
            $mail->isHTML(true);
            $mail->Subject = $MailTitle;
            $mail->Body    = $MailBody;
//            $mail->AltBody = '这是非HTML邮件客户端的纯文本';
            $SendResult=$mail->send();
            //echo $SendResult;
            if($SendResult==1){
            	Cache::set($ReceiveMail,$code,600);
            	return json(msg(1,'发送成功','接受邮箱'.$ReceiveMail));
            }else{
            	return json(msg(0,'发送失败','接受邮箱'.$ReceiveMail));
            }
        }catch (Exception $e){
        	return json(msg(0,'发送失败',$mail->ErrorInfo));
        }
	}
	public function doVerify()
	{
		$request=Request::instance()->param();
		$CacheCode=Cache::get($request['mail']);
		if (strtolower($request['code'])==strtolower($CacheCode)) {
			return json(msg(1,'验证成功',$CacheCode));
		}else{
			return json(msg(0,'验证失败',$CacheCode));
		}
	}
	
}
?>