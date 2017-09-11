<?php
/**
   院团和名角
   author jasxun
   date 2014-5-3
 */
class ClubAction extends BackendAction{
   protected $model_name = 'article'; 
    public function _initialize() {
    parent::_initialize();
  }
  public function _before_insert(){
   $_POST['cate_id'] = 3;//院团和名角栏目
   $_POST['addtime'] = time();
  }
  
  public function _filter(&$map){
    $map['cate_id'] = 3;
  }


	}