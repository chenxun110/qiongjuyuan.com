<?php
/**
 * 管理中心登录
 * author  jasxun
 * date 2014-4-22
 */
 class LoginAction extends Action{
 public function index(){
   if(!session('adminid')&&!session('username')){
        $this->display();
     }else{
	  $this->redirect('wxuser/set');  
	 }
 }
  public function checklogin(){
   //用户登录检测
 if(is_POST){
   $username = $this->_post('username');
   $password = $this->_post('password','trim');
  // $verify = $this->_post('verify','trim');
   if(empty($username)){
     echo json_encode(array('s'=>1,'msg'=>'请输入用户名'));exit();
   }
   if(empty($password)){
     echo json_encode(array('s'=>1,'msg'=>'请输入密码'));exit();
   }
   if(empty($verify)){
    // echo json_encode(array('s'=>1,'msg'=>'请输入验证码'));exit();
   }
   if(session('verify') != md5($verify)){
      // $this->ajaxReturn(array('s'=>1,'msg'=>'验证码不正确'),'json');
   }
   $result=M('admin')->where(array('username'=>$username))->find();
   if($result){
      if($result['password']==md5(md5($password).$result['addtime'])){
         $public=M('wxuser')->order('id desc')->find();
         session('token',$public['token']);
         session('wxname',$public['wxname']);
      	 session('adminid',$result['id']);
      	 session('username',$result['username']);
         echo json_encode(array('s'=>0,'msg'=>'登录成功','url'=>U('Wxuser/set')));exit();  
      }else{
      	echo json_encode(array('s'=>1,'msg'=>'密码错误'));exit();
      }
   }else{
     echo json_encode(array('s'=>1,'msg'=>'用户名不存在'));exit();
   }
    }

 }
  public function verify_code() {
    import("ORG.Util.Image"); //调用图片类，验证码
         Image::buildImageVerify(4,1,'gif','120','37');
     }
 
 } 