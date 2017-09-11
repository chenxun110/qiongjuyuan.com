<?php
/**
  我的信息
  author jasxun
  date   2014-04-12
 */
 class BackendAction extends BaseAction{
     protected function _initialize(){
     	parent::_initialize();
      if(!session('adminid')&&!session('username')){
      	$this->redirect(GROUP_NAME.'/Login/index');exit();
      }	
  }

 }