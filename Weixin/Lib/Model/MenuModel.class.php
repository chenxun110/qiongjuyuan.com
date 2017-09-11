<?php
class MenuModel extends RelationModel{
protected $tableName = 'menu';
  protected $_validate = array(
    array('title','require','填写菜单名称'), //默认情况下用正则进行验证
  );
 protected $_auto = array(
 	array('is_show','1'),  // 新增的时候把status字段设置为1

  );


}