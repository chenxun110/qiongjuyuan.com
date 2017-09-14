<?php
/*
 * 琼剧相关
 */
class NotifyAction extends BaseAction{

 //微信回调
 public function index(){
  	 $result = file_get_contents('php://input', 'r');
     file_put_contents('wxpay.txt', $result);
     //xml转化为数组格式
     $array_data = json_decode(json_encode(simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
	  if(!empty($array_data) && $array_data['result_code'] == 'SUCCESS') {
	  	$out_trade_no = $array_data['out_trade_no'];		//商户订单号
	  	$money = $array_data['total_fee']/100;			//交易金额
        //业务逻辑处理
        $bill = M('bill')->where(array('out_trade_no'=>$out_trade_no))->find();
        if(!empty($bill) && $bill['status']==0){
          //确认账单	
         M('bill')->where(array('out_trade_no'=>$out_trade_no))->save(array('status'=>1));
         M('book')->where(array('id'=>$bill['book_id']))->save(array('pay_status'=>1));
         M('booking_detail')->where(array('book_id'=>$bill['book_id']))->save(array('pay_status'=>1));
	  	//同步返回给微信参数   
	    echo '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';  
      }else{

      	 $bill = M('bill')->where(array('out_trade_no'=>$out_trade_no))->find();
          if(!empty($bill)){
          	   //确认账单	
          	  M('user_bill')->where(array('out_trade_no'=>$out_trade_no))->save(array('status'=>2));
          	  M('book')->where(array('id'=>$bill['book_id']))->save(array('pay_status'=>2));
          	  M('booking_detail')->where(array('book_id'=>$bill['book_id']))->save(array('pay_status'=>2));
          }
      	//同步返回给微信参数   
      	echo '<xml><return_code><![CDATA[FAIL]]></return_code><return_msg><![CDATA['.$array_data['return_msg'].']]></return_msg></xml>';
      }

 }