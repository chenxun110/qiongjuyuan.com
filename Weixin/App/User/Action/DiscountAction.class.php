<?php
/**
   优惠券
   author jasxun
   date 2014-5-3
 */
class DiscountAction extends BackendAction{
    public function _initialize() {
    parent::_initialize();
  }
  public function _before_insert(){
   $_POST['addtime'] = time();
   $_POST['start_time'] = strtotime($_POST['start_time']);
    $_POST['end_time'] = strtotime($_POST['end_time']);
  }
  public function _before_update(){
   $_POST['start_time'] = strtotime($_POST['start_time']);
    $_POST['end_time'] = strtotime($_POST['end_time']);
  }
  public function _filter(&$map){
  }


	}