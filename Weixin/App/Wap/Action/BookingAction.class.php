<?php
/*
 * 微信订票
 * date 2015-11-7
 * link http://jasxun1.sinaapp.com
 */
class BookingAction extends BaseAction{
//订票
public function index(){
if(isset($_GET['keyword']) && !empty($_GET['keyword'])){
        	$where['title'] = array('like','%'.$_GET['keyword'].'%');
        }	
 $where['status'] = 0;       
$this->list = M('schedule')->where($where)->select();
$this->display();
}
//订票内容页
public function details(){
$data = M('schedule')->where(array('id'=>$_GET['id']))->find();		
$price_content = unserialize($data['price_content']);
$this->assign('data',$data);
$this->assign('price_content',$price_content);
$this->display();
}
//微信预定
public function order(){
	if(IS_POST){
		if(!$_SESSION['uid']){
          echo json_encode(array('s'=>2,'msg'=>'请登陆'));exit();
		}
		if(!get_memberinfo($_SESSION['uid'],'mobile')){
            echo json_encode(array('s'=>3,'msg'=>'请绑定手机号','url'=>U('/Wap/member/set')));exit();
        }
		 $data = M('schedule')->where(array('id'=>$_POST['id']))->find();
		 $price_content = unserialize($data['price_content']);
		 $ym = get_type_piao($_POST['id'],$_POST['type_id']);
		 $sy = $price_content[0]['num']-$ym;
		 $all = get_all_piao($_POST['id']);
		 if($all==$data['num']){
		 	echo json_encode(array('s'=>1,'msg'=>'抱歉，暂无余票!'));exit();
		 }
		 if($sy<$_POST['num']){
		 	echo json_encode(array('s'=>1,'msg'=>'抱歉，暂无余票!'));exit();
		 }

		 $order['sn'] = randCode(3, 3).randCode(9, 1);
		 $order['schedule_id'] = $_POST['id'];
		 $order['member_id'] = $_SESSION['uid'];
		 $order['type_id'] = $_POST['type_id'];
		 $order['addtime'] = time();
		 $order['num'] = $_POST['num'];
		 $order['price'] = $_POST['price']*$_POST['num'];
		 $order['addtime'] = time();
		 $insert = M('order')->add($order);	
		 if($insert>0){
		 	 $new_all = get_all_piao($_POST['id']);
		 	M('schedule')->where(array('id'=>$_POST['id']))->save(array('pay_num'=>$new_all));
		 	echo json_encode(array('s'=>0,'msg'=>'恭喜您预订成功!','sn'=>$order['sn']));
		 }else{
           echo json_encode(array('s'=>1,'msg'=>'预订失败!'));
		 }
	}
}



}