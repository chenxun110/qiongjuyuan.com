<?php
/**
 *公众号设置
 *author jasxun
 *date   2014-11-17
 *link jasxun.sinaapp.com
*/
 class WxuserAction extends BackendAction{
    protected $is_token=false; //是否启用token
    function _filter(&$map){
        $map['uid'] = session('adminid');
    }
    public function welcome(){
     if(IS_POST){
     if(empty($_POST['welcome'])){
      echo json_encode(array('s'=>1,'msg'=>'回复内容不能为空','url'=>''));exit();
     } 
     $data['welcome'] = $_POST['welcome'];
     $data['id'] = $_POST['id'];
     $data['keyword'] = $_POST['keyword'];	
       $affid= M('wxuser')->save($data);
       if($affid !==false){
         echo json_encode(array('s'=>0,'msg'=>'操作成功','url'=>''));
       }else{
        echo json_encode(array('s'=>0,'msg'=>'操作成功','url'=>''));
       }
     }else{
     	 $vo= M('wxuser')->field('id,welcome,keyword')->find();
     	 $this->assign ('vo', $vo);
     	 $this->display();	
     }	
    
    }
    public function set(){
      if($_POST){
        $affid= M('wxuser')->save($_POST);
        if($affid !==false){
           $public=M('wxuser')->order('id desc')->find();
            session('wxname',$public['wxname']);
            echo json_encode(array('s'=>0,'msg'=>'操作成功','url'=>''));
        }else{
            echo json_encode(array('s'=>1,'msg'=>'操作失败','url'=>''));
        }
      
      }else{
         $vo= M('wxuser')->find();
         $this->assign ('vo', $vo);
         $this->display();
      }
    }
 }