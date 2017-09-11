<?php
/**
   音频管理
   author jasxun
   date 2014-5-3
 */
class AudioAction extends BackendAction{
  protected $model_name = 'video'; 
    public function _initialize() {
    parent::_initialize();
    $this->cate = M('videocate')->where(array('type'=>1))->select();
  }
  public function _before_insert(){
   $_POST['addtime'] = time();
  }
  public function index(){
      $model = M('video o');
    //取得满足条件的记录数
      $count = $model->join('left join wx_videocate c on c.id=o.cate_id')->count();
      //创建分页对象
      $listRows = 18;
      import('ORG.Util.Page');// 导入分页类
      $p = new Page ( $count, $listRows );
      //分页查询数据
      $voList = $model->join('left join wx_videocate c on c.id=o.cate_id')
                      ->field('c.subject,o.*')
                      ->where('c.type=1')
                      ->limit($p->firstRow . ',' . $p->listRows)
                      ->select ();
            
      //分页显示
      $page = $p->show ();
      //模板赋值显示
      $this->assign ( 'list', $voList );
      $this->assign ( "page", $page );
      $this->display();
  }
  public function _filter(&$map){

  }


	}