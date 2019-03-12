<?php 
namespace app\admin\model;

use think\Model;
use think\Db;
class UserPublic extends Model
{
	public function add()
    {
    	//插入数据
    	/*$data1 = ['name' => 'ly', 'data' => '1111'];
		$result1=Db::table('food_test')->insert($data);
		dump($result1);*/

		//插入多条数据
		/*$data2 = [['name' => 'ly2', 'data' => '1111'],['name' => 'ly2', 'data' => '222']];
		$result2=Db::table('food_test')->insertAll($data2);
		dump($result2);*/

		//快捷更新
		/*$result3=Db::name('test')->data(['name' => 'ly3', 'data' => '1111'])->insert();
		dump($result3);*/

    }
    public function del()
    {
    	// 根据主键删除
		/*Db::name('test')->delete(1);
		Db::name('test')->delete([1,2,3]);*/

		// 条件删除    
		//Db::name('test')->where('num',1)->delete();
		Db::name('test')->where('num','<',10)->delete();
    }
    public function edit()
    {
    	//编辑更新
    	//$result1=Db::name('test')->where('name', 'ly')->update(['name' => 'thinkphp']);
    	//包含主键,可以使用
    	//$result2=Db::name('test')->update(['name' => 'thinkphp','id'=>1]);
    	//延迟更新,10s后更新，主键
		$result3=Db::table('think_user')->where('name', 'thinkphp')->setInc('num', 1, 10);
    	dump($result3);
    	
    }
    public function select()
    {
    	//不使用表前缀
    	$result1=Db::table('food_data')->where('food_id','dn8Cia41T1elLaY2Ve5pXZxexL8tZvRq')->find();
    	//find 方法查询结果不存在，返回 null，否则返回结果数组
    	$result2=Db::name('data')->where('food_id','dn8Cia41T1elLaY2Ve5pXZxexL8tZvRq')->find();
    	//查询数据集
    	$result3=Db::name('data')->where('food_id','dn8Cia41T1elLaY2Ve5pXZxexL8tZvRq')->select();
    	//json查询
    	$result4=Db::name('data')->where('food_name','元宝红烧肉')->select();
    	//查询列
    	$result5=Db::name('data')->where('food_name','元宝红烧肉')->column('food_name');
    	//dump($result5);


    	//数据集分批处理（chunk）
    	Db::name('data')->chunk(20, function($data) {
		    foreach ($data as $everybody) {
		        dump($everybody);
		    }
		    echo "==================================================================================================";
		    return false;
		});
		//chunk方法的处理默认是根据主键查询，支持指定字段
		Db::name('data')->chunk(20, function($data) {
		    foreach ($data as $everybody) {
		        dump($everybody);
		    }
		    echo "==================================================================================================";
		    return false;
		},'food_name');
    }
    public function test()
    {
        // 模板变量赋值
        $this->assign('name','ThinkPHP');
        $this->assign('email','thinkphp@qq.com');
        // 或者批量赋值
        $this->assign([
            'name'  => 'ThinkPHP',
            'email' => 'thinkphp@qq.com'
        ]);
        //数组赋值
        $data['name']='data-tp5';
        $data['email']='data-email';
        $this->assign('data',$data);
        // 模板输出
        $result1=Db::name('test')->paginate(3,20);
        $page = $result1->render();
        $this->assign('test_data',$result1);
        $this->assign('page',$page);
        return $this->fetch('index');
    }
}
?>