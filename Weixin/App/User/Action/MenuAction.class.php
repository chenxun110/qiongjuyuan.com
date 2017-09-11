<?php
/**
   自定义菜单
   author jasxun
   date 2014-5-3
 */
class MenuAction extends BackendAction{
    public function _initialize() {
    parent::_initialize();
  }
    function index(){
     $list = M('menu')->select();
     $list = self::get_list($list);
     $this->assign('list',$list);
     $this->display();
    }
		function _before_insert(){
	  if(!empty($_POST['url'])){
	    $_POST['type'] = 'view';
	  }else{
      $_POST['type'] = 'click';
    }
	}
    function add(){
     $cate = M('menu')->where(array('pid'=>0))->select();
     $this->assign('cate',$cate);
     $this->display();
    }
	function _before_update(){
	  if(!empty($_POST['url'])){
	    $_POST['type'] = 'view';
	  }else{
       $_POST['type'] = 'click';
    }
	}
    function edit(){
     $model = D('menu');
     $id = $_REQUEST [$model->getPk()];
     $vo = $model->getById($id);
     $cate = M('menu')->where(array('pid'=>0))->select();
     $this->assign('vo', $vo);
     $this->assign('cate',$cate);
     $this->display();
    }
   static function get_list($list,$pid = 0,$html='|----',$level=0){
     $arr= array();
      foreach($list as $val){
          if($val['pid'] == $pid){
          $val['level'] = $level+1;
        $val['html'] = str_repeat($html,$level);
          $arr[]=$val;  
          $arr = array_merge($arr,self::get_list($list,$val['id'],$html,$level+1));
      }
    }
   return $arr ;   
  }
  
  //生成自定义菜单
  public function send(){
    if(IS_POST){
      $api = M('wxuser')->find();
      if (empty($api['AppId'])|| empty($api['Secret'])){
         echo json_encode(array('s'=>1,'msg'=>'当前公众号未填写AppId和Secret','url'=>''));exit;
      }
      //微信
      $url_get = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$api['AppId'].'&secret='.$api['Secret'];
      $result = file_get_contents($url_get);//获取内容
      if (empty($result)){
        $ch = curl_init();//初始化一个cURL会话. curl_setopt设置一个cURL传输选项
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt ($ch, CURLOPT_URL, $url_get);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);//执行一个cURL会话
        curl_close($ch);
      }
      $json = json_decode($result);
      $data = '{"button":[';
      $class = M('menu')->where(array('pid'=>0,'is_show'=>1))->limit(3)->order('sort desc')->select();//最多3个一级菜单
      $i = 1;
      foreach($class as $key=>$vo){
        //main menu主菜单
        $data .= '{"name":"'.$vo['title'].'",';
        $c = M('menu')->where(array('pid'=>$vo['id'],'is_show'=>1))->limit(5)->order('sort desc')->select();//最多5个二级菜单
        $count = M('menu')->where(array('pid'=>$vo['id'],'is_show'=>1))->limit(5)->order('sort desc')->count();
        //sub menu子菜单
        if($c != false){
          $data .= '"sub_button":[';
        }else{
          if ($vo['type'] == "click") {
            $data .= '"type":"click","key":"'.$vo['keyword'].'"';//关键字
          } else {
            $data .= '"type":"view","url":"'.$vo['url'].'"';//链接
          }
        }
        $i = 1;
        foreach($c as $voo){
          if($i == $count){
            if ($voo['type'] == "click") {
              $data .= '{"type":"click","name":"'.$voo['title'].'","key":"'.$voo['keyword'].'"}';
            } else {
              $data .= '{"type":"view","name":"'.$voo['title'].'","url":"'.$voo['url'].'"}';
            }
          }else{
            if ($voo['type'] == "click") {
              $data .= '{"type":"click","name":"'.$voo['title'].'","key":"'.$voo['keyword'].'"},';
            } else {
              $data .= '{"type":"view","name":"'.$voo['title'].'","url":"'.$voo['url'].'"},';
            }
          }
          $i++;
        }
        if($c!=false){
          $data .= ']';
        }
        if($key < 2){
          $data .= '},';
        }elseif($key == 2){
          $data .= '}';
        }
      }
      $data .= ']}';
      file_get_contents('https://api.weixin.qq.com/cgi-bin/menu/delete?access_token='.$json->access_token);//删除菜单
      $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$json->access_token;//生成菜单
      $result = json_decode(https_request($url,$data),true);
      if($result['errcode']==0){
        echo json_encode(array('s'=>0,'msg'=>'生成成功','url'=>''));exit;
      }else{
       echo json_encode(array('s'=>1,'msg'=>'生成失败','url'=>''));exit;
      }
    }else{
      echo json_encode(array('s'=>1,'msg'=>'非法操作','url'=>''));exit;
    }
  }

  
}
