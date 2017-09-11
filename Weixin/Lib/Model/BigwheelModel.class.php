<?php
class BigwheelModel extends RelationModel{
protected $tableName = 'bigwheel';
  protected $_validate = array(
    array('title','require','填写活动名称'),
    array('keyword','require','填写关键词'), 
    array('thumb','require','上传图文封面'), 
    array('brief','require','填写简介'),
    array('content','require','填写内容详情'), 
    array('total_times','require','填写每天允许抽奖次数'), 
    array('rate','require','填写中奖概率'),
  );
 protected $_auto = array(
 	  array('addtime','time',1,'function'), // 对token字段在新增的时候回调gettoken方法

  );

}