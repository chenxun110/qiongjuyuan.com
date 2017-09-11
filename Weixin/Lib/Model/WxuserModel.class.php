<?php
class WxuserModel extends RelationModel{
 protected $tableName = 'wxuser';
 protected $_validate =array(
    array('wxname','','公众号名称已经存在！',0,'unique',1), // 在新增的时候验证wxname字段是否唯一
    array('wxname','require','公众号名称必须填写！'), //默认情况下用正则进行验证
    array('wxid','','公众号原始ID已经被使用',0,'unique',1), // 在新增的时候验证wxid字段是否唯一
    array('wxid','require','公众号原始ID必须填写！'), //默认情况下用正则进行验证
   
 	);
 protected $_auto = array(
    array('uid','getuid',1,'callback'), // 对uid字段在新增的时候回调getuid方法
    array('addtime','time',1,'function'), // 对create_time字段在更新的时候写入当前时间戳
 	);
    public function getuid(){
     return session('uid');
  }

}