<?php

class BookingAction extends BaseAction{

	public function index(){

	$this->display();

	}

	public function place_api(){
	 $schedule_id = $_GET['schedule_id'];
	 $placeList = M('place p')->join('left join wx_place_type t on p.type_id=t.id')->field('p.id as place_id,p.name,p.type_id,p.place,t.price')->select();
	 foreach ($placeList as $key => $val) {
	 	$placeList[$key]['book'] = is_booking($val['place_id'],$schedule_id);
	 }
	 echo json_encode($placeList);

	}

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
			$detailResult = M('booking_detail')->where(['schedule_id'=>$schedule_id,'place_id'=>$val,'status'=>1])->find();
			$place = M('place')->where(['id'=>$val])->find();
            if($detailResult){
            	echo json_encode(['status'=>1,'msg'=>$place['name']."已经被抢购,请重新选座！"]);exit();
            }
		}

		foreach ($placeIdArr as $key => $val) {
			$detailResult = M('booking_detail')->where(['schedule_id'=>$schedule_id,'place_id'=>$val,'member_id'=>$member_id])->find();
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
		echo json_encode(['status'=>0,'msg'=>,'选座成功！']);exit();
	}
   
   //输入信息
	public function input_info(){
     $this->display();
	}

    //确认订单【支付】
  	public function weixin_pay(){
  	 $this->display();	
  	}


    //订单详情
  	public function order_detail(){
  		$this->display();
  	}

}