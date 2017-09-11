<?php
/**
   琼剧概括
   author jasxun
   date 2014-5-3
 */
class ArticleAction extends BackendAction{
    public function _initialize() {
    parent::_initialize();
  }
  public function _before_insert(){
   $_POST['cate_id'] = 1;//琼剧概括栏目
   $_POST['addtime'] = time();
  }
  
  public function _filter(&$map){
    $map['cate_id'] = 1;
  }


	}