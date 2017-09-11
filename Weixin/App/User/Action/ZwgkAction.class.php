<?php
/**
   政务公开
   author jasxun
   date 2014-5-3
 */
class ZwgkAction extends BackendAction{
   protected $model_name = 'article'; 
    protected $is_token=false; //是否启用token
    public function _initialize() {
    parent::_initialize();
    
  }
  public function _before_insert(){
   if(!$_POST['title']){
     echo json_encode(array('s'=>1,'msg'=>'请输入标题！','url'=>''));exit();
   } 
    if(!$_POST['content']){
     echo json_encode(array('s'=>1,'msg'=>'请输入内容！','url'=>''));exit();
   } 
   $_POST['cate_id'] = 4;//政务公开
   $_POST['addtime'] = time();
  }
  
  public function _filter(&$map){
    $map['cate_id'] = 4;
  }


	}