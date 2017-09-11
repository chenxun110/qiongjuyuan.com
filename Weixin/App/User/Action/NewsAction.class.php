<?php
/**
   戏曲新闻
   author jasxun
   date 2014-5-3
 */
class NewsAction extends BackendAction{
    protected $model_name = 'article'; 
    public function _initialize() {
    parent::_initialize();
  }
  public function _before_insert(){
   $_POST['cate_id'] = 2;//戏曲新闻栏目
   $_POST['addtime'] = time();
  }
  
  public function _filter(&$map){
    $map['cate_id'] = 2;
  }
  public function insert(){
    if (isset($this->model_name) && $this->model_name){
      $name = $this->model_name;
    }else{
      $name = $this->getActionName();
    }
    $model = D($name);
    if (false === $model->create()) {
      $msg=$model->getError();
      echo json_encode(array('s'=>1,'msg'=>$msg,'url'=>''));exit();
    }
    
    $list = $model->add();
    if ($list>0){
           //同步
            get_pc($list);
            echo json_encode(array('s'=>0,'msg'=>'操作成功','url'=>U('index')));
    } else {
            echo json_encode(array('s'=>1,'msg'=>'操作失败','url'=>''));
    } 
}

	}