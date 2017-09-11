<?php
/**
   演出排期
   author jasxun
   date 2014-5-3
 */
class ScheduleAction extends BackendAction{
    protected $is_token=false; //是否启用token
    public function _initialize() {
    parent::_initialize();
  }
  public function _before_insert(){
   $_POST['addtime'] = time();
   $_POST['price_content'] = serialize( $_POST['price_content']);
   $_POST['start_time'] = strtotime($_POST['start_time']);
    $_POST['end_time'] = strtotime($_POST['end_time']);
     $_POST['adv'] = implode(',', $_POST['adv']);
  }
  public function _before_update(){
   $_POST['price_content'] = serialize( $_POST['price_content']);
   $_POST['start_time'] = strtotime($_POST['start_time']);
   $_POST['end_time'] = strtotime($_POST['end_time']);
   $_POST['adv'] = implode(',', $_POST['adv']);

  }
  public function _filter(&$map){
  }


	}