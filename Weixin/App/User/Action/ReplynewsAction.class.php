<?php
/**
 *单图文管理
 *author jasxun
 *date 2014-11-20
 *email 249543262@qq.com
 */
class ReplynewsAction extends BackendAction{
  public function _initialize() {
    parent::_initialize();
    
  }

  public function insert(){

	$model = D('Replynews');
	if (false === $model->create()) {
		$msg=$model->getError();
		echo json_encode(array('s'=>1,'msg'=>$msg,'url'=>''));exit();
	}
	$insert_id = $model->add();
	if ($insert_id>0){
        $k_data['keyword'] = $_POST['keyword'];
        $k_data['type'] = 2;
        $k_data['aim_id'] = $insert_id;
        $k_data['source_table'] = 'replynews';
        $k_data['addtime'] = time();
		M('keyword')->add($k_data);
        echo json_encode(array('s'=>0,'msg'=>'操作成功','url'=>U('index')));
	} else {
        echo json_encode(array('s'=>1,'msg'=>'操作失败','url'=>''));
	}	
}

 public function update(){
		$model = D('Replynews');
		if (false === $model->create()) {
			$msg=$model->getError();
			echo json_encode(array('s'=>1,'msg'=>$msg,'url'=>''));exit();
		}
		$list = $model->save();
		if ($list !== false) {
			$result = M('keyword')->where(array('source_table'=>'replynews','aim_id'=>$_POST['id']))->find();
	        $k_data['keyword'] = $_POST['keyword'];
	        if(empty($result)){
	        	$k_data['aim_id'] = $_POST['id'];
	        	$k_data['type'] = 2;
	            $k_data['source_table'] = 'replynews';
	            $k_data['addtime'] = time();
	        	M('keyword')->add($k_data);
	        }else{
	        	M('keyword')->where(array('source_table'=>'replynews','aim_id'=>$_POST['id']))->save($k_data);
	        }
            echo json_encode(array('s'=>0,'msg'=>'操作成功','url'=>U('index')));
		} else {
            echo json_encode(array('s'=>1,'msg'=>'操作失败','url'=>''));
		}	
    }

}