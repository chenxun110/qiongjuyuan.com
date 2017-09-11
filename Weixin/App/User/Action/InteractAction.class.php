<?php
/**
   互动平台
   author jasxun
   date 2014-5-3
 */
class InteractAction extends BackendAction{
    public function _initialize() {
    parent::_initialize();
  }
  public function _before_insert(){
   $_POST['addtime'] = time();
  }
  
  public function _filter(&$map){
  }


	}