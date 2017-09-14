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
    $_POST['playtime'] = strtotime($_POST['playtime']);
  }
  public function _before_update(){
   $_POST['playtime'] = strtotime($_POST['playtime']);

  }
  public function _filter(&$map){
  }


	}