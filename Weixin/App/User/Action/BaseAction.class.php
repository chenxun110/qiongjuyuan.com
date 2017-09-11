<?php
session_start();
class BaseAction extends Action{
	protected $model_name = '';	//模型名称，如果为空则取控制器名称
	protected function _initialize(){
		$this->assign ('module_name', MODULE_NAME);
	}
	
    public function index() {
		if (isset($this->model_name) && $this->model_name){
			$name = $this->model_name;
		}else{
			$name = $this->getActionName();
		}
		$model = D($name);
		//列表过滤器，生成查询Map对象
		$map = $this->_search($name);
		
		if (method_exists ( $this, '_filter' )) {
			$this->_filter($map);
		}
	
		if (!empty($model)) {
			$this->_list($model, $map);
		}
		$this->assign ('parameter', $_REQUEST);
		$this->display ();
		return;
	}
	protected function _list($model, $map) {
		//取得满足条件的记录数
		$count = $model->where($map)->count($model->getPk());
		if ($count > 0) {
			//创建分页对象
			$listRows = 18;
			import('ORG.Util.Page');// 导入分页类
			$p = new Page ( $count, $listRows );
			//分页查询数据
			$voList = $model->where($map)->order('id desc')->limit($p->firstRow . ',' . $p->listRows)->select ( );
            
			//分页显示
			$page = $p->show ();
			//模板赋值显示
			$this->assign ( 'list', $voList );
			$this->assign ( "page", $page );
		}
		return;
	}

    protected function _search($name='') {
    	//生成查询条件
   		if (isset($this->model_name) && $this->model_name){
			$name = $this->model_name;
		}else{
			$name = $this->getActionName();
		}
    	$model = D($name);
    	$map = array();
    	foreach($model->getDbFields() as $key => $val) {
    		if (isset($_REQUEST[$val]) && $_REQUEST[$val] != '') {
    			$map[$val] = $_REQUEST[$val];
    		}
    	}
    	return $map;
    }
    public function add(){
     $this->display();	
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
            echo json_encode(array('s'=>0,'msg'=>'操作成功','url'=>U('index')));
		} else {
            echo json_encode(array('s'=>1,'msg'=>'操作失败','url'=>''));
		}	
    }
    public function edit(){
    	if (isset($this->model_name) && $this->model_name){
			$name = $this->model_name;
		}else{
			$name = $this->getActionName();
		}

    	$model = D($name);
    	$id = $_REQUEST [$model->getPk()];
    	$vo = $model->getById($id);
    	$this->assign('vo', $vo);
        $this->assign ('parameter', $_REQUEST);
    	$this->display ();
    }
    public function update(){
		if (isset($this->model_name) && $this->model_name){
			$name = $this->model_name;
		}else{
			$name = $this->getActionName();
		}
		$model = D($name);
		if (false === $model->create()) {
			$msg=$model->getError();
			echo json_encode(array('s'=>1,'msg'=>$msg,'url'=>''));
		}
		
		$list = $model->save();
		if ($list !== false) {
            echo json_encode(array('s'=>0,'msg'=>'操作成功','url'=>U('index')));
		} else {
            echo json_encode(array('s'=>1,'msg'=>'操作失败','url'=>''));
		}	
    }
    public function delete() {
		if (isset($this->model_name) && $this->model_name){
			$name = $this->model_name;
		}else{
			$name = $this->getActionName();
		}
		
		$model = D($name);
		$pk = $model->getPk();
		$id = intval($_REQUEST[$pk]);
		$condition = array ($pk => array ('eq', $id) );
		$list = $model->where($condition)->delete();
		if ($list !== false) {
             echo json_encode(array('s'=>0,'msg'=>'操作成功','url'=>U('index')));
		} else {
             echo json_encode(array('s'=>1,'msg'=>'操作失败','url'=>''));exit();
		}	
	}
 //异步改变状态
  public function ajax_status(){
   if(IS_AJAX){
   	if (isset($this->model_name) && $this->model_name){
			$name = $this->model_name;
		}else{
			$name = $this->getActionName();
		}
		
	 $model = D($name);
	 $pk = $model->getPk();
     $id = $this->_post('id','trim');
     $result = $model->where(array('id'=>$id))->find();
     if ($result['is_show']==1){
          $row = $model->where(array('id'=>$id))->setField('is_show',0);
          $data['html'] = '<span style="cursor:pointer;" class="btn disabled btn-mini">否</span>';
     }else{
         $row = $model->where(array('id'=>$id))->setField('is_show',1);
          $data['html'] = '<span style="cursor:pointer;" class="btn btn-success disabled btn-mini">是</span>';
     }   

        $data['status'] = 1;
        $this->ajaxReturn($data,'JSON');
    }
  }
}