<?php
/**
   微信预定
   author jasxun
   date 2014-5-3
 */
class OrderAction extends BackendAction{
    public function _initialize() {
    parent::_initialize();
  }
  public function index(){
     $model = M('order o');
    //取得满足条件的记录数
      $count = $model->join('left join wx_member m on m.id=o.member_id')->count();
      //创建分页对象
      $listRows = 18;
      import('ORG.Util.Page');// 导入分页类
      $p = new Page ( $count, $listRows );
      //分页查询数据
      $voList = $model->join('left join wx_member m on m.id=o.member_id')
                      ->join('left join wx_schedule s on s.id=o.schedule_id')
                      ->field('s.title,m.wxname,m.mobile,s.end_time,o.*')->limit($p->firstRow . ',' . $p->listRows)->select ();
            
      //分页显示
      $page = $p->show ();
      //模板赋值显示
      $this->assign ( 'list', $voList );
      $this->assign ( "page", $page );
      $this->display();
  }
  public function _before_insert(){
   $_POST['addtime'] = time();
  }
  
  public function _filter(&$map){
  }
  public function order_status(){
       if(IS_AJAX){
       $model = M('order');
       $pk = $model->getPk();
         $id = $this->_post('id','trim');
         $result = $model->where(array('id'=>$id))->find();
         $time = time();
         if ($result['status']==1){
             echo json_encode(array('s'=>1,'msg'=>'已兑换过'));exit();
         }
          $row = $model->where(array('id'=>$id))->save(array('status'=>1,'use_time'=>$time)); 
            if($row>0){
              $data['s'] = 0;
              $data['msg'] = '兑换成功';
              $data['span'] = '<span style="color:red;">已兑换</span>';
              $data['utime'] =  date('Y-m-d H:i:s',$time);
            }else{
              $data['s'] = 1;
              $data['msg'] = '兑换失败';
            }
            $this->ajaxReturn($data,'JSON');
        }
  }

	}