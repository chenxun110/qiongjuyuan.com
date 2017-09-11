<?php
/**
 * 微信大转盘管理 
 * author jasxun
 * date 2014-12-15
 * email 249543262@qq.com
 */
class BigwheelAction extends BackendAction{
  public function _initialize() {
    parent::_initialize();
  }
  public function _before_insert(){
  $_POST['prize'] = serialize($_POST['prize']);
  $_POST['begin_day'] = strtotime($_POST['begin_day']);
  $_POST['end_day'] = strtotime($_POST['end_day']);
  }
  public function insert(){
	$model = D('Bigwheel');
	if (false === $model->create()) {
		$msg=$model->getError();
		$this->error($msg);
	}
	$insert_id = $model->add();
	if ($insert_id>0){
        $k_data['keyword'] = $_POST['keyword'];
        $k_data['type'] = 4;
        $k_data['aim_id'] = $insert_id;
        $k_data['source_table'] = 'bigwheel';
        $k_data['addtime'] = time();
		M('keyword')->add($k_data);
        $this->success('添加成功',U('index'));
	} else {
        $this->error('添加失败');
	}	
  }
  public function _before_update(){
  $_POST['prize'] = serialize($_POST['prize']);
  $_POST['begin_day'] = strtotime($_POST['begin_day']);
  $_POST['end_day'] = strtotime($_POST['end_day']);
  }
  public function update(){
	$model = D('Bigwheel');
	if (false === $model->create()) {
		$msg=$model->getError();
		$this->error($msg);
	}
	$aff_id = $model->save();
	if (false !== $aff_id){
		$result = M('keyword')->where(array('source_table'=>'bigwheel','aim_id'=>$_POST['id']))->find();
        $k_data['keyword'] = $_POST['keyword'];
        if(empty($result)){
        	$k_data['aim_id'] = $_POST['id'];
        	$k_data['type'] = 4;
            $k_data['source_table'] = 'bigwheel';
            $k_data['addtime'] = time();
        	M('keyword')->add($k_data);
        }else{
        	M('keyword')->where(array('source_table'=>'bigwheel','aim_id'=>$_POST['id']))->save($k_data);
        }
        $this->success('保存成功',U('index'));
	} else {
        $this->error('保存失败');
	}	
  }
  	function edit(){
		$model = D('Bigwheel');
		$id = $_REQUEST [$model->getPk()];
		$vo = $model->getById($id);
		$vo['prize'] = unserialize($vo['prize']);
		$this->assign('vo', $vo);
	    $this->assign ('parameter', $_REQUEST);
		$this->display ();
	}

}