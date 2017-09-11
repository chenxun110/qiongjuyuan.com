<?php
/*
 * 演出排期
 * date 2015-11-7
 * link http://jasxun1.sinaapp.com
 */
class ScheduleAction extends BaseAction{
//演出排期
public function index(){
if(isset($_GET['keyword']) && !empty($_GET['keyword'])){
        	$where['title'] = array('like','%'.$_GET['keyword'].'%');
        }	
 $where['status'] = 0;       
$this->list = M('schedule')->where($where)->select();	
$this->display();
}
//剧目详情
public function details(){
$this->data = M('schedule')->where(array('id'=>$_GET['id']))->find();	
$this->display();
}




}