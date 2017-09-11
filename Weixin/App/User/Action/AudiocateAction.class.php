<?php
class AudiocateAction extends BackendAction{
  protected $model_name = 'videocate'; 
    protected $is_token=false; //是否启用token
    public function _initialize() {
    parent::_initialize();
  }
  public function _before_insert(){
   $_POST['addtime'] = time();
   $_POST['adv'] = implode(',', $_POST['adv']);
   $_POST['type'] = 1;
  }
  public function _before_update(){
    $_POST['adv'] = implode(',', $_POST['adv']);
    $_POST['type'] = 1;
  }

  public function _filter(&$map){
  $map['type']=1;
  }


	}