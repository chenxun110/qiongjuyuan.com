<?php
/**
  我的信息
  author jasxun
  date   2014-04-12
 */
 class IndexAction extends BackendAction{
 //账号信息 
 public function index(){
 	$this->display();
 }
 
 //登录退出
 public function logout(){
  session(null);
  $this->redirect('Login/index');
 }
  /**修改密码**/
  public function changepassword(){
    if(IS_POST){
     $result = M('admin')->where(array('id'=>session("adminid")))->find();
     $password = $this->_post('password','trim');
     $newpassword = $this->_post('newpassword','trim');
     $cnewpassword = $this->_post('cnewpassword','trim');
     if(!$password){
     	 echo json_encode(array('s'=>1,'msg'=>'原始密码不能为空','url'=>''));exit();  
     }
     if(!$newpassword){
     	 echo json_encode(array('s'=>1,'msg'=>'新密码不能为空','url'=>''));exit();  
     }
     if(!$cnewpassword){
     	 echo json_encode(array('s'=>1,'msg'=>'确认密码不能为空','url'=>''));exit();  
     }
     if($result['password']==md5(md5($password).$result['addtime'])){
        if($newpassword==$cnewpassword){
         $data = array('password'=>md5(md5($newpassword).$result['addtime']));
        	$aff_id = M('admin')->where(array('id'=>session("adminid")))->save($data);
 	       	if($aff_id){
 	           echo json_encode(array('s'=>1,'msg'=>'修改成功','url'=>U('logout')));exit();  	
 	       	}else{
 	        	 echo json_encode(array('s'=>1,'msg'=>'修改失败','url'=>''));exit();  	
 	       	}
        }else{
          echo json_encode(array('s'=>1,'msg'=>'两次密码不一致！','url'=>''));exit();  	
        }
     }else{
     	 echo json_encode(array('s'=>1,'msg'=>'原始密码有误!','url'=>''));exit();  	
     }
    }else{
    	$this->display();
    }
  }
 }