<?php
/*
 * 会员中心
 * date 2015-11-7
 * link http://jasxun1.sinaapp.com
 */
class MemberAction extends BaseAction{
//会员首页
public function index(){
   //$redurect_uri = C('SITE_URL').'/Wap/Member/index';
   //第一步：用户同意授权，获取code
  // $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode($redurect_uri).'&response_type=code&scope=snsapi_base&state=123#wechat_redirect';
  // $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx1cc1929d3b6c7b11&redirect_uri='.urlencode($redurect_uri).'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect';
  // echo $url;

$this->member = M('member')->where(array('id'=>$_SESSION['uid']))->find();	
$this->order = M('order o')->join('left join wx_schedule s on o.schedule_id=s.id')
                           ->field('s.title,s.start_time,s.end_time,o.sn,o.price,o.num,o.addtime,o.status')
                           ->where("o.member_id={$_SESSION['uid']}")
                           ->order('o.id desc')
                           ->select();
$this->discount = M('discount')->order('id desc')->select();                                                        
$this->display();
}
//互动平台
public function bbs(){
	$this->list = M('interact i')->join('left join wx_member m on m.id=i.member_id')
                               ->field('m.wxname,m.id,m.headerpic,i.*')
                               ->where("i.ispublish=0")
                               ->order('i.id desc')
                               ->select();
  // echo  M('interact i')->getLastsql();                           
	$this->display();
}
//互动平台内容页
public function bbsdetails(){
   M('interact i')->where("id={$_GET['id']}")->setInc('hits');

   $this->data =  M('interact i')->join('left join wx_member m on m.id=i.member_id')
                                 ->field('m.wxname,m.id,m.headerpic,i.*')
                                 ->where("i.ispublish=0 and i.id={$_GET['id']}")
                                 ->find();
   $this->list  = M('comment c')->join('left join wx_member m on c.member_id=m.id')
                                 ->limit(10)
                                 ->field('c.*,m.wxname,m.headerpic')
                                 ->where("c.cid={$_GET['id']} and c.type_id=3")
                                 ->order('c.id desc')
                                 ->select();                                
   $this->display();
}
//互动发表文章
public function postbbs(){
  if(IS_POST){
    if(!$_SESSION['uid']){
      echo json_encode(array('s'=>2,'msg'=>'请登陆'));exit();
    }
    if(!$_POST['title']){
      echo json_encode(array('s'=>1,'msg'=>'请输入标题'));exit();
    }
    if(!$_POST['content']){
      echo json_encode(array('s'=>1,'msg'=>'请输入内容'));exit();
    }
    $interact['title'] = $_POST['title'];
    $interact['content'] = $_POST['content'];
    $interact['member_id'] = $_SESSION['uid'];
    $interact['video_url'] = $_POST['video_url'];
    $interact['audio_url'] = $_POST['audio_url'];
    $interact['pic']       = $_POST['pic'];
    $interact['ispublish']       = 0;
    $interact['addtime']       = time();
    $insert_id = M('interact')->add($interact);
   // echo M('interact')->getLastsql();
    if($insert_id>0){
      echo json_encode(array('s'=>0,'msg'=>'发布成功')); 
    }else{
      echo json_encode(array('s'=>1,'msg'=>'发布失败'));
    }

  }else{
     $this->display();
  }

  
}
//用户资料设置
public function set(){
   if(IS_POST){
    if(!$_SESSION['uid']){
      echo json_encode(array('s'=>2,'msg'=>'请登陆'));exit();
    }
    if(!$_POST['wxname']){
       echo json_encode(array('s'=>'1','msg'=>'请输入微信昵称'));exit();
    }
    if(!$_POST['mobile']){
       echo json_encode(array('s'=>'1','msg'=>'请输入手机号'));exit();
    }
    if(!is_numeric($_POST['mobile']) || strlen(trim($_POST['mobile']))!=11){
      echo json_encode(array('s'=>'1','msg'=>'请输入正确的手机号'));exit();
    }
     $member['wxname']=$_POST['wxname'];
     $member['mobile']=$_POST['mobile'];
     $member['headerpic']=$_POST['headerpic'];
     $member['id'] = $_SESSION['uid'];
     $affid = M('member')->save($member);
     //echo M('member')->getLastsql();
     if($affid!==false){
       echo json_encode(array('s'=>'0','msg'=>'设置成功'));
     }else{
       echo json_encode(array('s'=>'1','msg'=>'设置失败'));
     }
   }else{
    $this->member = M('member')->where(array('id'=>$_SESSION['uid']))->find(); 
    $this->display();
   }
  
}
//点赞
public function zan(){
  if(IS_POST){
  	if(!$_SESSION['uid']){
  		echo json_encode(array('s'=>2,'msg'=>'请登陆'));exit();
  	}
  	$zan_id = $_POST['id'];
  	if(is_zan($_SESSION['uid'],$zan_id)==1){
  		echo json_encode(array('s'=>1,'msg'=>'已点赞过'));exit();
  	}
    $insert_id = M('zan')->add(array('add_time'=>time(),'zan_id'=>$zan_id,'member_id'=>$_SESSION['uid']));	
   	if($insert_id>0){
       	$zans =  M('zan')->where(array('zan_id'=>$zan_id))->count();
        $zandata = array('id'=>$zan_id,'zans'=>$zans);
        M('interact')->save($zandata);
        echo json_encode(array('s'=>0,'msg'=>'点赞成功','zans'=>$zans));
     }else{
     	echo json_encode(array('s'=>1,'msg'=>'点赞失败'));
     }	
  }

}
//取消点赞
public function cancel_zan(){
  if(IS_POST){
    if(!$_SESSION['uid']){
      echo json_encode(array('s'=>2,'msg'=>'请登陆'));exit();
    }
    $zan_id = $_POST['id'];
    if(is_zan($_SESSION['uid'],$zan_id)==0){
      echo json_encode(array('s'=>1,'msg'=>'未点赞过'));exit();
    }
    $insert_id = M('zan')->where(array('zan_id'=>$zan_id,'member_id'=>$_SESSION['uid']))->delete();  
    if($insert_id>0){
        $zans =  M('zan')->where(array('zan_id'=>$zan_id))->count();
        $zandata = array('id'=>$zan_id,'zans'=>$zans);
        M('interact')->save($zandata);
        echo json_encode(array('s'=>0,'msg'=>'取消成功','zans'=>$zans));
     }else{
      echo json_encode(array('s'=>1,'msg'=>'取消失败'));
     }  
  }

}
//取消加心
public function cancel_likes(){
  if(IS_POST){
  	if(!$_SESSION['uid']){
  		echo json_encode(array('s'=>2,'msg'=>'请登陆'));exit();
  	}
  	$likes_id = $_POST['id'];
  	if(is_like($_SESSION['uid'],$likes_id)==0){
  		echo json_encode(array('s'=>1,'msg'=>'未加心过'));exit();
  	}
    $insert_id = M('likes')->where(array('likes_id'=>$likes_id,'member_id'=>$_SESSION['uid']))->delete();	
   	if($insert_id>0){
       	$likes =  M('likes')->where(array('likes_id'=>$likes_id))->count();
        $likesdata = array('id'=>$likes_id,'likes'=>$likes);
        M('interact')->save($likesdata);
        echo json_encode(array('s'=>0,'msg'=>'取消成功','likes'=>$likes));
     }else{
     	echo json_encode(array('s'=>1,'msg'=>'取消失败'));
     }	
  }

}
//加心
public function likes(){
  if(IS_POST){
    if(!$_SESSION['uid']){
      echo json_encode(array('s'=>2,'msg'=>'请登陆'));exit();
    }
    $likes_id = $_POST['id'];
    if(is_like($_SESSION['uid'],$likes_id)==1){
      echo json_encode(array('s'=>1,'msg'=>'已加心过'));exit();
    }
    $insert_id = M('likes')->add(array('add_time'=>time(),'likes_id'=>$likes_id,'member_id'=>$_SESSION['uid']));  
    if($insert_id>0){
        $likes =  M('likes')->where(array('likes_id'=>$likes_id))->count();
        $likesdata = array('id'=>$likes_id,'likes'=>$likes);
        M('interact')->save($likesdata);
        echo json_encode(array('s'=>0,'msg'=>'加心成功','likes'=>$likes));
     }else{
      echo json_encode(array('s'=>1,'msg'=>'加心失败'));
     }  
  }

}
//领取优惠券
public function get_discount(){
     if(IS_POST){
       if(!$_SESSION['uid']){
        echo json_encode(array('s'=>2,'msg'=>'请登陆'));exit();
       }
       if(!get_memberinfo($_SESSION['uid'],'mobile')){
            echo json_encode(array('s'=>3,'msg'=>'请绑定手机号','url'=>U('/Wap/member/set')));exit();
        }
        $data = M('discount')->where(array('id'=>$_POST['id']))->find();

        $all = get_all_piao($_POST['id']);
        if($all==$data['num']){
          echo json_encode(array('s'=>1,'msg'=>'抱歉，暂无优惠券!'));exit();
        }
        $result  = M('discount_order')->where(array('member_id'=>$_SESSION['uid'],'discount_id'=>$_POST['id']))->find();
         if($result){
          echo json_encode(array('s'=>1,'msg'=>'已领取过!'));exit();
         }
         $discount_order['sn'] = randCode(3, 3).randCode(9, 1);
         $discount_order['discount_id'] = $_POST['id'];
         $discount_order['member_id'] = $_SESSION['uid'];
         $discount_order['addtime'] = time();
         $insert = M('discount_order')->add($discount_order); 
         //echo M('discount_order')->getLastsql();
         if($insert>0){
           $new_all = get_all_discount($_POST['id']);
           M('discount')->where(array('id'=>$_POST['id']))->save(array('pay_num'=>$new_all));
           echo json_encode(array('s'=>0,'msg'=>'恭喜您领取成功!','sn'=>$discount_order['sn']));
         }else{
               echo json_encode(array('s'=>1,'msg'=>'领取失败!'));
         }
     }
     
}
 public function commit(){
  if(IS_POST){
    if(!$_SESSION['uid']){
      echo json_encode(array('s'=>2,'msg'=>''));exit();
    }
    if(!$_POST['content']){
      echo json_encode(array('s'=>1,'msg'=>'请输入内容'));exit();
    }
    $data['member_id'] = $_SESSION['uid'];  
    $data['type_id'] = 3; 
    $data['content'] = $_POST['content']; 
    $data['cid'] = $_POST['cid']; 
    $data['addtime'] = time();  
    $insert = M('comment')->add($data);
    if($insert>0){
       $count = M('comment')->where(array('cid'=>$_POST['cid'],'type_id'=>3))->count();
       M('interact')->where(array('id'=>$_POST['cid']))->save(array('comments'=>$count));
      echo json_encode(array('s'=>0,'msg'=>'评论成功','name'=>$_SESSION['wxname'],'img'=>$_SESSION['headerpic'],'date'=>date('Y-m-d',$data['addtime']),'content'=>$_POST['content']));
    }else{
      echo json_encode(array('s'=>1,'msg'=>'评论失败'));
    }
  }
 }

}