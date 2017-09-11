<?php 
/**
 *  手机端访问
 *  author jasxun
 *  date 2014-7-3 17:31
 */
 class ArticeAction extends BaseAction{
 	  public function _initialize() {
 	}
 	
 	//琼剧概况
 	public function index(){
        $this->list=M('article')->limit(1000)->order('id desc')->where(array('cate_id'=>1))->select();
		$this->display();
	}
	//一般文章内容页 
 	public function details(){
 		$this->data = M('article')->where(array('id'=>$_GET['id']))->find();
		$this->display();
	}	
	public function newslist(){
		if(isset($_GET['keyword']) && !empty($_GET['keyword'])){
			$where['title'] = array('like','%'.$_GET['keyword'].'%');
		}
		$where['cate_id'] = 2;
		$this->list=M('article')->limit(1000)->order('id desc')->where($where)->select();
		$this->display();
	}
	public function newsdetails(){
		$this->data = M('article')->where(array('id'=>$_GET['id']))->find();
		$this->display();
	}
	public function troupelist(){//院团和名角列表页
		if(isset($_GET['keyword']) && !empty($_GET['keyword'])){
			$where['title'] = array('like','%'.$_GET['keyword'].'%');
		}
		$where['cate_id'] = 3;
		$this->list=M('article')->limit(1000)->order('id desc')->where($where)->select();
		$this->display();
	}
	public function zwgklist(){
		if(isset($_GET['keyword']) && !empty($_GET['keyword'])){
			$where['title'] = array('like','%'.$_GET['keyword'].'%');
		}
		$where['cate_id'] = 4;
		$this->list=M('article')->limit(1000)->order('id desc')->where($where)->select();
		$this->display();
	}
	public function troupedetails(){//名角内容页
		$this->data = M('article')->where(array('id'=>$_GET['id']))->find();
		$this->display();
	}
	public function amateurlist(){//社团列表页
		$this->display();
	}
	public function video(){ //视频内容页
		$this->data  = M('video')->where(array('id'=>$_GET['id']))->find();
		$this->list  = M('comment c')->join('left join wx_member m on c.member_id=m.id')
				                             ->limit(10)
				                             ->field('c.*,m.wxname,m.headerpic')
				                             ->where("c.cid={$_GET['id']} and c.type_id=1")
				                             ->order('c.id desc')
				                             ->limit(1000)
				                             ->select();
		$this->display();
	}
	public function audio(){ //音频内容页
		$this->data = M('video')->where(array('id'=>$_GET['id']))->find();
		$this->list  = M('comment c')->join('left join wx_member m on c.member_id=m.id')
		                             ->limit(10)
		                             ->field('c.*,m.wxname,m.headerpic')
		                             ->where("c.cid={$_GET['id']} and c.type_id=2")
		                             ->order('c.id desc')
		                             ->limit(1000)
		                             ->select();
		$this->display();
	}
	public function cordetails(){ //剧团内容页
		$this->display();
	}
	public function media(){ //多媒体资料
        if(isset($_GET['keyword']) && !empty($_GET['keyword'])){
        	$where['title'] = array('like','%'.$_GET['keyword'].'%');
        }
        $where['available'] = 1;
		$this->list = M('videocate')->limit(1000)->order('id desc')->where($where)->select();
		$this->display();
	}
	public function media_video(){ //视频
        if(isset($_GET['keyword']) && !empty($_GET['keyword'])){
        	$where['title'] = array('like','%'.$_GET['keyword'].'%');
        }
        $where['type'] = 0;
        $where['available'] = 1;
		$this->list = M('videocate')->limit(1000)->order('id desc')->where($where)->select();
		$this->display();
	}
	public function media_audio(){ //音频
        if(isset($_GET['keyword']) && !empty($_GET['keyword'])){
        	$where['title'] = array('like','%'.$_GET['keyword'].'%');
        }
        $where['type'] = 1;
        $where['available'] = 1;
		$this->list = M('videocate')->limit(1000)->order('id desc')->where($where)->select();
		$this->display();
	}
	public function videolist(){ //视频列表
		if(isset($_GET['keyword']) && !empty($_GET['keyword'])){
        	$where['title'] = array('like','%'.$_GET['keyword'].'%');
        }
        $where['cate_id'] = $_GET['id'];
		$this->list=M('video')->where($where)->select();
		$this->data = M('videocate')->where(array('id'=>$_GET['id']))->find();
		$this->display();
	}
	public function audiolist(){ //音频列表
		if(isset($_GET['keyword']) && !empty($_GET['keyword'])){
        	$where['title'] = array('like','%'.$_GET['keyword'].'%');
        }
        $where['cate_id'] = $_GET['id'];
		$this->list=M('video')->where($where)->select();
		$this->data = M('videocate')->where(array('id'=>$_GET['id']))->find();
		$this->display();
	}
	public function about(){ //关于我们
		$this->data = M('about')->find();
		$this->display();
	}
	public function call(){ //关于我们-拨打电话
		$this->data = M('about')->find();
		$this->display();
	}
	public function map(){ //关于我们-地图
		$this->display();
	}
    public function commit(){
    	if(IS_POST){
    	  if(!$_SESSION['uid']){
    	  	echo json_encode(array('s'=>2,'msg'=>''));exit();
    	  }
    	  $uid = M('member')->where(array('id'=>$_SESSION['uid']))->find();
    	  if(!$uid){
    	    session(null);
    	    session_destroy();
    	    echo json_encode(array('s'=>2,'msg'=>''));exit();
    	  }
    	  if(!$_POST['content']){
    	    echo json_encode(array('s'=>1,'msg'=>'请输入内容'));exit();
    	  }
    	  $data['member_id'] = $_SESSION['uid'];	
    	  $data['type_id'] = $_POST['type_id'];	
    	  $data['content'] = $_POST['content'];	
    	  $data['cid'] = $_POST['cid'];	
    	  $data['addtime'] = time();	
    	  $insert = M('comment')->add($data);
    	  if($insert>0){
    	  	echo json_encode(array('s'=>0,'msg'=>'评论成功','name'=>$_SESSION['wxname'],'img'=>$_SESSION['headerpic'],'date'=>date('Y-m-d',$data['addtime']),'content'=>$_POST['content']));
    	  }else{
    	  	echo json_encode(array('s'=>1,'msg'=>'评论失败'));
    	  }
    	}
    }
    //登录
    public function login(){
		 	$_SESSION['uid'] = 1;
		    echo json_encode(array('s'=>0,'msg'=>'登录成功'));
    }
     //注册
      public function register(){
      	 if(IS_POST){

      	 	    if(!$_POST['name']){
                    echo json_encode(array('s'=>1,'msg'=>'请输入您的昵称'));exit();
      	 	    }
      	 	    $name = M('member')->where(array('wxname'=>$_POST['name']))->find();
      	 	     if($name){
                    echo json_encode(array('s'=>1,'msg'=>'昵称已经存在'));exit();
      	 	    }
      	 	    if(!$_POST['mobile']){
                    echo json_encode(array('s'=>1,'msg'=>'请输入您的手机号'));exit();
      	 	    }
                if(strlen($_POST['mobile'])!=11){
                    echo json_encode(array('s'=>1,'msg'=>'请输入您的11位手机号'));exit();
      	 	    }
      	 	    if(checkMobile($_POST['mobile'])==0){
                    echo json_encode(array('s'=>1,'msg'=>'请输入正确的手机号'));exit();
      	 	    }
      	 	    $result = M('member')->where(array('mobile'=>$_POST['mobile']))->find();
      	 	     if($result){
                    echo json_encode(array('s'=>1,'msg'=>'手机号已经存在'));exit();
      	 	    }
                
      	 	     $member['wxname'] = $_POST['name'];
      	 	     $member['mobile'] = $_POST['mobile'];
      	 	     $member['sex'] = $_POST['sex'];
                 $member['addtime'] = time();
                 $member['cardid'] = random(16, 1);
      	 	     $insert=M('member')->add($member);

      	 	     if($insert>0){
      	 	       $_SESSION['uid'] = $insert;
      	 	       $_SESSION['wxname'] = $_POST['name'];
      	 	       $_SESSION['cardid'] = $member['cardid'];
      	 	       echo json_encode(array('s'=>0,'msg'=>'注册成功'));
      	 	     }else{
      	 	     	echo json_encode(array('s'=>1,'msg'=>M('member')->getLastsql()));
      	 	     }
      	 		
      	 }
      	  
      }
 
 
 }
