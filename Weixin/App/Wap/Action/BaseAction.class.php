<?php
/**
 *公共类
 */
class BaseAction extends Action{
  protected $openid;	
 protected function _initialize(){
     	$agent = $_SERVER['HTTP_USER_AGENT']; 
     	if(!strpos($agent,"MicroMessenger")){
			 //echo '此功能只能在微信浏览器中使用';exit;
		}else{
      if(!$_SESSION['uid']){
             getuserinfo();
          }else{
            $uid = M('member')->where(array('id'=>$_SESSION['uid']))->find();
            if(!$uid){
              session(null);
              session_destroy();
            }
          }
    }   

        
  }

}