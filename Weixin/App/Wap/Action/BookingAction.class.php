<?php
//微信订票
class BookingAction extends BaseAction{
    //舞台大厅
	public function index(){

	$this->display();

	}
    //座位接口
	public function place_api(){
	 $schedule_id = $_GET['schedule_id'];
	 $placeList = M('place p')->join('left join wx_place_type t on p.type_id=t.id')->field('p.id as place_id,p.name,p.type_id,p.place,t.price')->select();
	 foreach ($placeList as $key => $val) {
	 	$placeList[$key]['book'] = is_booking($val['place_id'],$schedule_id);
	 }
	 echo json_encode($placeList);

	}
     //我的订单
	public function order(){
		
    $this->display();
	}
    
    //选座
	public function seat(){
		$now =time();
		$placeId = "1,2";
		$placeIdArr = explode(',', $placeId);
		$schedule_id = 525;
		$member_id = 4;
		$token = "gh_8fbbef2cdbc6";
		$order_no = date('YmdHms').randCode(5, 1);
		$all_num = count($placeIdArr);
		$all_price = M('place p')->join('left join wx_place_type t on p.type_id=t.id')->where(['p.id'=>['in',$placeId]])->sum('t.price');

		foreach ($placeIdArr as $key => $val) {
			$detailResult = M('booking_detail')->where(['schedule_id'=>$schedule_id,'place_id'=>$val,'pay_status'=>1])->find();
			$place = M('place')->where(['id'=>$val])->find();
            if($detailResult){
            	echo json_encode(['status'=>1,'msg'=>$place['name']."已经被抢购,请重新选座！"]);exit();
            }
		}

		foreach ($placeIdArr as $key => $val) {
			$detailResult = M('booking_detail')->where(['schedule_id'=>$schedule_id,'place_id'=>$val,'member_id'=>$member_id,'pay_status'=>0])->find();
			$place = M('place')->where(['id'=>$val])->find();
            if($detailResult){
            	echo json_encode(['status'=>1,'msg'=>$place['name']."已经选被您选过,请重新选座！"]);exit();
            }
		}

		$book = [
			'schedule_id'=>$schedule_id,
			'addtime'=>$now,
			'token'=>$token,
			'member_id'=>$member_id,
			'all_num'=>$all_num,
			'all_price'=>$all_price
		];
		$book_id = M('book')->add($book);
		M('book')->where(['id'=>$book_id])->save(['order_no'=>$order_no]);
		foreach ($placeIdArr as $key => $val) {
			$place = M('place p')->join('left join wx_place_type t on p.type_id=t.id')->where(['p.id'=>$val])->field('t.price')->find();
			$bookingDetail = [
             'schedule_id' => $schedule_id,
             'addtime'     => $now,
             'token'       => $token,
             'member_id'   => $member_id,
             'place_id'    => $val,
             'price'       => $place['price'],
             'book_id'     => $book_id
			];
			$did = M('booking_detail')->add($bookingDetail);
			$sn = randCode(6, 1); 
			M('booking_detail')->where(['id'=>$did])->save(['sn'=>$sn]);
		}
		echo json_encode(['status'=>0,'msg'=>'选座成功！','book_id'=>$book_id]);exit();
	}
   
   //输入信息
	public function input_info(){

	$book_id = $_GET['book_id'];
	$this->assign('book_id',$book_id);	
    $this->display();

	}

    //确认订单【支付】
  public function weixin_pay(){
	   ini_set('date.timezone','Asia/Shanghai');
	   error_reporting(E_ERROR);
	   require_once APP_PATH."Common/Wxpay/lib/WxPay.Api.php";
	   require_once APP_PATH."Common/Wxpay/WxPay.JsApiPay.php";
	   $book_id = $_GET['book_id'];
	   $book =  M('book')->where(['id'=>$book_id])->find();
	   $now = time();
	   $out_trade_no = $now . randCode(6, 1);    //商户侧订单号
	   $bill = [
	   'money'  => $book['all_price'],
	   'out_trade_no' => $out_trade_no,
	   'add_time' => $now,
	   'status'=>0,
	   'member_id' =>$book['member_id'],
	   'book_id' =>$book_id
	   ];
	   $insert_id = M('bill')->add($bill);
	   //①、获取用户openid
	   $tools = new \JsApiPay();
	   //$openId = $tools->GetOpenid();
	   $openId = "oxQLOjunGWVszGwKifWyPmDHTMjQ";
	   $money   = $bill['money'];
	   $body  = $bill['remark'];
	   $out_trade_no = $bill['out_trade_no'];
	   $total_fee = 100*$bill['money'];
	   $notify_url = C('SITE_URL')."/wap/notify/index";
	   $trade_type ="JSAPI";

	   //②、统一下单
	   /*$input = new \WxPayUnifiedOrder();
	   $input->SetBody($body);
	   $input->SetOut_trade_no($out_trade_no);
	   $input->SetTotal_fee($total_fee);
	   $input->SetNotify_url($notify_url);
	   $input->SetTrade_type($trade_type);
	   $input->SetOpenid($openId);
	   $order = \WxPayApi::unifiedOrder($input);
	   $jsApiParameters = $tools->GetJsApiParameters($order);
	   $this->assign('jsApiParameters',$jsApiParameters);*/
	   $this->assign('total_fee',$bill['money']);
  	   $this->display();	
  	}


    //订单详情
  	public function order_detail(){
  		$this->display();
  	}
  
}