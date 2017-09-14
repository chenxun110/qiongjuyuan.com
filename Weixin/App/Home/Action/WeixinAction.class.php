<?php
/**
 *微信验证接口
 *author jasxun
 *date 2014-9-25
 *email chx@loongme.com
 */
error_reporting(0);
class WeixinAction extends Action{
    public $token;//接收token参数
    public $data = array();
    public function index(){
        //验证接口
        $weixin = new Wechat(C('TOKEN'),C('EncodingAESKey'),C('AppID'));
        $data = $weixin->request();
        $this->data =$data;
        $this->token = $data ['ToUserName'];
        //是否指定公众号！
        if(get_wxid()!==false){
            if($this->token !=get_wxid()){
                return "";
            }
        }
        //消息处理
        list($content, $type) = $this->reply($data);
        $weixin->response($content, $type);
    }
    /**
     * 消息回复
     * author jasxun
     */
    public function reply($data){
        //点击事件
        if ('click' == strtolower($data['Event'])) {
            $data['Content'] = $data['EventKey'];
        }
		//扫码推事件的事件推送 
        if ('scancode_push' == strtolower($data['Event'])) {
            $data['Content'] = $data['EventKey'];
        }
		//扫码推事件且弹出“消息接收中”提示框的事件推送
        if ('scancode_waitmsg' == strtolower($data['Event'])) {
            $data['Content'] = $data['EventKey'];
			return array($data['ScanResult'],'text');
        }
		//弹出系统拍照发图的事件推送 
        if ('pic_sysphoto' == strtolower($data['Event'])) {
            $data['Content'] = $data['EventKey'];
        }
		//弹出拍照或者相册发图的事件推送  
        if ('pic_photo_or_album' == strtolower($data['Event'])) {
            $data['Content'] = $data['EventKey'];
        }
		//弹出微信相册发图器的事件推送  
        if ('pic_weixin' == strtolower($data['Event'])) {
            $data['Content'] = $data['EventKey'];
        }
		//弹出地理位置选择器的事件推送   
        if ('location_select' == strtolower($data['Event'])) {
            $data['Content'] = $data['EventKey'];
        }
		

         //用户关注
        if ('subscribe' == strtolower($data['Event'])) { 
           //会员处理
                       //会员处理
            $member = M('member')->field('id')->where(array('openid'=>$this->data['FromUserName']))->find();
            if(!empty($member)){
                //更新会员信息
                $access_token =get_accesstoken();
                //获得会员信息
                $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$this->data['FromUserName']}&lang=zh_CN";
                $json_arr = json_decode(remotedata($url), true);
                $data_arr = array(
                    'headerpic' =>$json_arr['headimgurl'],
                    'wxname' =>$json_arr['nickname'],
                );
                //更新
                M('member')->where(array('openid'=>$this->data['FromUserName']))->save($data_arr);

            }else{
                //新增会员
                $access_token =get_accesstoken();
                //获得会员信息
                $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$this->data['FromUserName']}&lang=zh_CN";
                $json_arr = json_decode(remotedata($url), true);
                $data_arr = array(
                    'openid' => $this->data['FromUserName'],
                    'headerpic' =>$json_arr['headimgurl'],
                    'wxname' =>$json_arr['nickname'],
                    'addtime' => time(),
                );
                //新增
                M('member')->add($data_arr);

            }

           //回复处理 
           $wxuser=M('wxuser')->find();
           if($wxuser['keyword']){
            //关键词回复
            $return = $this->keyword($key);
           }elseif ($wxuser['welcome']) {
             $return = array($wxuser['welcome'],'text');
           }
            if(empty($return)){
               $return = array('','text');
            }
             return $return;
           
        }
        //用户扫码事件推送
        if('user_scan_product' == strtolower($data['Event'])) { 
           //扫一扫记录【开发中】
        }


       //获取用户地理位置【需用户同意】
       if ('location' == strtolower($data['Event'])) {
            //上报位置处理
             $return = array('','text');
             return $return;
        }

       //匹配回复 
        $key = $data['Content'];
        switch ($key) {
                 //自定义关键词回复  
            case '订票':
               $msg ="";
               $return = array('','text');
                return $return;
              break;      
            default:
                 //关键词回复
                  $return = $this->keyword($key);
                  if(empty($return)){
                     $return = array('','text');
                   }
                    return $return;
                  
            break;
        }


    }
    /**
     * 关键词回复
     * author jasxun
     */
   public function keyword($key){
     $where['keyword'] = array('like','%'.$key.'%');
     $keyword = M('keyword')->where($where)->find();
     if(!empty($keyword)){
         $reply = M($keyword['source_table'])->where(array('id'=>$keyword['aim_id']))->find();
         if(!empty($reply)){
            switch ($keyword['type']) {
                case 1:
                    break;
                case 2:
                //2=图片回复；
                  if(!empty($reply['content'])){
                    //如果定义的内容详情
                     $reply['url'] = C('SITE_URL').U('Wap/Artice/index',array('id'=>$reply['id']));
                  }
                     $return[] = array($reply['title'],$reply['description'],$reply['picurl'],$reply['url']);
                     return array(
                            $return,
                            'news'
                     );    
                    break;
                case 3:
                //3=多图文回复；
                   $news_data = explode(',', $reply['news_data']);//拆分成数组
                    foreach ($news_data as $k => $v) {
                        $news = M('Replynews')->where(array('id'=>$v))->find();
                         if(!empty($news['content'])){
                            //如果定义的内容详情【开发中】
                            $news['url'] = C('SITE_URL').U('Wap/Artice/index',array('id'=>$news['id']));
                          }
                        $return[] = array($news['title'],$news['description'],$news['picurl'],$news['url']);
                    }    
                    return array(
                            $return,
                            'news'
                     );    
                    break;            
            }
         }
     }


      return $return;
   }
}

