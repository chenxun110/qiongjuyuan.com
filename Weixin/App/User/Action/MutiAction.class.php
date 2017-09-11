<?php
/**
 *多图文管理
 *author jasxun
 *date 2014-11-20
 *email 249543262@qq.com
 */
class MutiAction extends BackendAction{
  public function _initialize() {
    parent::_initialize();
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
			$voList = $model->where($map)->limit($p->firstRow . ',' . $p->listRows)->select ( );
            foreach ($voList as $k => $v) {
            	$where['id'] = array('IN',$v['news_data']);
    	        $voList[$k]['child'] = M('Replynews')->where($where)->field('title,picurl,addtime')->select();
            }
			//分页显示
			$page = $p->show ();
			//模板赋值显示
			$this->assign ( 'list', $voList );
			$this->assign ( "page", $page );
		}
		return;
	}
  public function insert(){
    if(count($_POST['news_data'])<2){
     $this->error('至少选择两条图文');	
    }	
    $_POST['news_data']= implode(',', $_POST['news_data']);
	$model = D('Muti');
	if (false === $model->create()) {
		$msg=$model->getError();
		$this->error($msg);
	}
	$insert_id = $model->add();
	if ($insert_id>0){
        $k_data['keyword'] = $_POST['keyword'];
        $k_data['type'] = 3;
        $k_data['aim_id'] = $insert_id;
        $k_data['source_table'] = 'muti';
        $k_data['addtime'] = time();
		M('keyword')->add($k_data);
        $this->success('添加成功',U('index'));
	} else {
        $this->error('添加失败');
	}	
}
	function edit(){
		$model = D('Muti');
		$id = $_REQUEST [$model->getPk()];
		$vo = $model->getById($id);
    	$where['id'] = array('IN',$vo['news_data']);
		$vo['news_data']=M('Replynews')->where($where)->select();
		$this->assign('vo', $vo);
	    $this->assign ('parameter', $_REQUEST);
		$this->display ();
	}

    public function update(){
    	$_POST['news_data']= implode(',', $_POST['news_data']);
		$model = D('Muti');
		if (false === $model->create()) {
			$msg=$model->getError();
			$this->error($msg);
		}
		$list = $model->save();
		if ($list !== false) {
			$result = M('keyword')->where(array('source_table'=>'muti','aim_id'=>$_POST['id']))->find();
	        $k_data['keyword'] = $_POST['keyword'];
	        if(empty($result)){
	        	$k_data['aim_id'] = $_POST['id'];
	        	$k_data['type'] = 3;
	            $k_data['source_table'] = 'muti';
	            $k_data['addtime'] = time();
	        	M('keyword')->add($k_data);
	        }else{
	        	M('keyword')->where(array('source_table'=>'muti','aim_id'=>$_POST['id']))->save($k_data);
	        }
            $this->success('保存成功',U('index'));
		} else {
            $this->error('保存失败');
		}	
    }
    function selectenews(){
		import('ORG.Util.Page');// 导入分页类
		$count      = M('Replynews')->count();// 查询满足要求的总记录数
		$Page       = new Page($count,9);// 实例化分页类 传入总记录数和每页显示的记录数
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = M('Replynews')->order('addtime')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
    	$this->display();
    }
    function selectids(){
    	$ids = $_POST['ids'];
    	$html='';
    	$where = array();
    	$where['id'] = array('IN',$ids);
    	$list = M('Replynews')->where($where)->select();
        foreach ($list as $k => $v) {
        	$html .=' <li><input name="news_data[]" type="hidden" value="'.$v['id'].'">'.$v['title'].'<a href="javascript:void(0);" class="btn btn-mini btn-danger del-news"><i class="icon-remove"></i> 删除</a></li>';
        }
        echo json_encode(array('status'=>1,'msg'=>$html));	
    }
}