<?php
/**
   关于我们
   author jasxun
   date 2014-5-3
 */
class AboutAction extends BackendAction{
    public function _initialize() {
    parent::_initialize();
  }
  public function index(){
    if(IS_POST){
      $data['content'] = $_POST['content'];
       $data['thumb'] = $_POST['thumb'];
      if(isset($_POST['id'])&&!empty($_POST['id'])){
        $data['id'] = $_POST['id'];
       M('about')->save($data);
      }else{
        M('about')->add($data);
      }
     echo json_encode(array('s'=>0,'msg'=>'操作成功','url'=>U('index')));
    }else{
      $this->vo = M('about')->find();
      $this->display();
    }
  }


	}