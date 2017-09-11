<?php
class ReplynewsModel extends RelationModel{
protected $tableName = 'replynews';
  protected $_validate = array(
    array('title','require','填写标题'), //默认情况下用正则进行验证
    array('keyword','require','填写关键词'), //默认情况下用正则进行验证
    array('picurl','require','填写图文封面'), //默认情况下用正则进行验证
    array('description','require','填写描述'), //默认情况下用正则进行验证
  );
 protected $_auto = array(
 	array('addtime','time',1,'function'), // 对token字段在新增的时候回调gettoken方法

  );


}