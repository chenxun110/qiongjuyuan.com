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
		$member_id = 4;
		$bookList = M('book b')->field('b.pay_status,b.schedule_id,b.id as book_id,b.order_no,s.title,s.yctt,s.address,s.playtime')->join('left join wx_schedule s on s.id=b.schedule_id')->where("b.member_id={$member_id}")->select();
		foreach ($bookList as $k => $val) {
			$detailList = M('booking_detail d')->field('p.name,p.place')->join('left join wx_place p on p.id=d.place_id')->where(['d.member_id'=>$member_id,'d.schedule_id'=>$val['schedule_id'],'d.book_id'=>$val['book_id']])->select();
		  $bookList[$k]['detailList'] =$detailList; 	
		}
		$this->assign('bookList',$bookList);
	    $this->display();
	}

    //选座
	public function seat(){
		$now =time();
		$placeId = "1,2";
		$placeIdArr = explode(',', $placeId);
		$schedule_id = 525;
		$member_id = 4;
		$order_no = date('YmdHms').randCode(5, 1);//微信票号
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
		$openid = "o5Wc0uNM45AQF6wdkMORZO1OgZME";
        if(IS_POST){
           $mobile = $_POST['mobile'];
           $real_name = $_POST['real_name'];
           $age = $_POST['age'];
           $sex = $_POST['sex'];
           $book_id = $_POST['book_id'];
           if(!$mobile){
           	 echo json_encode(['status'=>1,'msg'=>"请填写手机号"]);exit();
           }
           if(!$real_name){
           	 echo json_encode(['status'=>1,'msg'=>"请填写姓名"]);exit();
           }
          M('book')->where(['id'=>$book_id])->save(['mobile'=>$mobile,'real_name'=>$real_name,'age'=>$age,'sex'=>$sex]);
          M('member')->where(['openid'=>$openid])->save(['mobile'=>$mobile,'real_name'=>$real_name,'age'=>$age,'sex'=>$sex]);
        }else{
	        $book_id = 31; 
			$member_id = 4;
			$book = M('book b')->field('b.real_name,b.age,b.sex,b.mobile,b.pay_status,b.schedule_id,b.id as book_id,b.order_no,s.title,s.yctt,s.address,s.playtime')->join('left join wx_schedule s on s.id=b.schedule_id')->where("b.member_id={$member_id}")->find();

			$detailList = M('booking_detail d')->field('p.name,p.place')->join('left join wx_place p on p.id=d.place_id')->where(['d.member_id'=>$member_id,'d.schedule_id'=>$book['schedule_id'],'d.book_id'=>$book_id])->select();
		    //var_dump($detailList);
		    //var_dump($book);
			$this->assign('detailList',$detailList);
			$this->assign('book',$book);
			$this->assign('book_id',$book_id);	
		    $this->display();
	        }


	}

    //确认订单【支付】
  public function weixin_pay(){
	   ini_set('date.timezone','Asia/Shanghai');
	   error_reporting(E_ERROR);
	   require_once APP_PATH."Common/Wxpay/lib/WxPay.Api.php";
	   require_once APP_PATH."Common/Wxpay/WxPay.JsApiPay.php";
	    $book_id = 31;
		$member_id = 4;
		$book = M('book b')->field('b.all_price,b.schedule_id,b.id as book_id,b.order_no,s.title,s.yctt,s.address,s.playtime')->join('left join wx_schedule s on s.id=b.schedule_id')->where("b.member_id={$member_id}")->find();

		$detailList = M('booking_detail d')->field('p.name,p.place')->join('left join wx_place p on p.id=d.place_id')->where(['d.member_id'=>$member_id,'d.schedule_id'=>$book['schedule_id'],'d.book_id'=>$book_id])->select();
       //var_dump($detailList);
      // var_dump($book);
	   $this->assign('detailList',$detailList);
	   $this->assign('book',$book);

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
  		$book_id = 31; 
		$member_id = 4;
		$book = M('book b')->field('b.pay_status,b.schedule_id,b.id as book_id,b.order_no,s.title,s.yctt,s.address,s.playtime')->join('left join wx_schedule s on s.id=b.schedule_id')->where("b.member_id={$member_id}")->find();

		$detailList = M('booking_detail d')->field('p.name,p.place')->join('left join wx_place p on p.id=d.place_id')->where(['d.member_id'=>$member_id,'d.schedule_id'=>$book['schedule_id'],'d.book_id'=>$book_id])->select();
        //var_dump($detailList);
        //var_dump($book);
		$this->assign('detailList',$detailList);
		$this->assign('book',$book);
  		$this->display();
  	}
    
    //剧目列表
  	public function schedule(){
	  	$list = M('schedule')->where(['status'=>1])->select();
	  	//var_dump($list);
	  	$this->assign('list',$list);
	    $this->display();
  	}
  	//剧目详情
  	public function schedule_detail(){
  		$schedule_id = 525;
	  	$schedule = M('schedule')->where(['status'=>1,'id'=>$schedule_id])->find();
	  	//var_dump($schedule);
	  	$this->assign('schedule',$schedule);
	    $this->display();
  	}
  
}