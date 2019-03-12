<?php
namespace app\user\model;
use think\Model;
class CollectModel extends Model
{
	// 确定链接表名
    protected $name = 'collect';
	//开启时间存储
    //protected $autoWriteTimestamp = true;
    //设置时间存储类型，默认为int
    protected $autoWriteTimestamp = 'datetime';
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    //电影收藏
    public function collectMovie(){
    }
}
?>