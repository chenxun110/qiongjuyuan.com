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
		}   if(!$_SESSION['uid']){
           getuserinfo();
        }else{
          $uid = M('member')->where(array('id'=>$_SESSION['uid']))->find();
          if(!$uid){
            session(null);
            session_destroy();
          }
        }
        
  }

  //图片上传处理
  public function upload(){
        if(isset($_SERVER['HTTP_APPNAME'])){ 
           //新浪云
           $domain = 'public'; //图片domain名称   
            $s = new SaeStorage();  
            //获得文件扩展名
            $file_name = $_FILES['pic']['name'];
            //服务器上临时文件名
            $tmp_name = $_FILES['pic']['tmp_name'];
            $temp_arr = explode(".", $file_name);
            $file_ext = array_pop($temp_arr);
            $file_ext = trim($file_ext);
            $file_ext = strtolower($file_ext);
            date_default_timezone_set("Asia/Shanghai");
            $ymd = date('Ymd');
            //新文件名
            $new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
            //文件存储路径  
            $new_file_name = 'upload/' . $ymd . "/" . $new_file_name;  
              
            $r = $s->upload( $domain , $new_file_name , $tmp_name);   
            $img_url =  $s->getUrl( $domain , $new_file_name);      
            exit(json_encode(array('s'=>0,'msg'=>'上传成功','url'=>$img_url,'name'=>$file_name,'tmp'=>$tmp_name)));
        }else{ 
               $savePath =  './Public/upload/image'.'/'.date('y').'/'.date('md').'/';// 设置附件上传目录
               //目录不存在创建目录【递级】
               if(!is_dir('./Public/upload/image'.'/'.date('y').'/')){
                       @mkdir('./Public/upload/image'.'/'.date('y').'/', 0755);
                       @fclose();
                   }
              //目录不存在创建目录【递级】
               if(!is_dir($savePath)){
                    @mkdir($savePath, 0755);
                    @fclose();
               }
              import('ORG.Net.UploadFile');
              $upload = new UploadFile();// 实例化上传类
              $upload->maxSize  = 10000000;//10M，php.ini需配置
              //$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
              $upload->savePath =  $savePath;// 设置附件上传目录
               if(!$upload->upload()) {// 上传错误提示错误信息
                   exit(json_encode(array('s'=>1,'msg'=>$upload->getErrorMsg(),'url'=>'')));
               }else{// 上传成功 获取上传文件信息
                   $info =  $upload->getUploadFileInfo();
               }
               $img = $upload->savePath.$info[0]['savename']; // 保存上传的附件根据需要自行组装
               $img_url = C('SITE_URL').'/'.ltrim($img, './');
               exit(json_encode(array('s'=>0,'msg'=>'上传成功','url'=>$img_url)));
             }
        }
  //图片上传处理
  public function audio_upload(){
        if(isset($_SERVER['HTTP_APPNAME'])){ 
           //新浪云
           $domain = 'public'; //图片domain名称   
            $s = new SaeStorage();  
            //获得文件扩展名
            $file_name = $_FILES['audio']['name'];
            //服务器上临时文件名
            $tmp_name = $_FILES['audio']['tmp_name'];
            $temp_arr = explode(".", $file_name);
            $file_ext = array_pop($temp_arr);
            $file_ext = trim($file_ext);
            $file_ext = strtolower($file_ext);
            date_default_timezone_set("Asia/Shanghai");
            $ymd = date('Ymd');
            //新文件名
            $new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
            //文件存储路径  
            $new_file_name = 'upload/' . $ymd . "/" . $new_file_name;  
              
            $r = $s->upload( $domain , $new_file_name , $tmp_name);   
            $img_url =  $s->getUrl( $domain , $new_file_name);      
            exit(json_encode(array('s'=>0,'msg'=>'上传成功','url'=>$img_url)));
        }else{ 
               $savePath =  './Public/upload/image'.'/'.date('y').'/'.date('md').'/';// 设置附件上传目录
               //目录不存在创建目录【递级】
               if(!is_dir('./Public/upload/image'.'/'.date('y').'/')){
                       @mkdir('./Public/upload/image'.'/'.date('y').'/', 0755);
                       @fclose();
                   }
              //目录不存在创建目录【递级】
               if(!is_dir($savePath)){
                    @mkdir($savePath, 0755);
                    @fclose();
               }
              import('ORG.Net.UploadFile');
              $upload = new UploadFile();// 实例化上传类
              $upload->maxSize  = 10000000;//10M，php.ini需配置
              //$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
              $upload->savePath =  $savePath;// 设置附件上传目录
               if(!$upload->upload()) {// 上传错误提示错误信息
                   exit(json_encode(array('s'=>1,'msg'=>$upload->getErrorMsg(),'url'=>'')));
               }else{// 上传成功 获取上传文件信息
                   $info =  $upload->getUploadFileInfo();
               }
               $img = $upload->savePath.$info[0]['savename']; // 保存上传的附件根据需要自行组装
               $img_url = C('SITE_URL').'/'.ltrim($img, './');
               exit(json_encode(array('s'=>0,'msg'=>'上传成功','url'=>$img_url)));
             }
        }
    //图片上传处理
  public function video_upload(){
        if(isset($_SERVER['HTTP_APPNAME'])){ 
           //新浪云
           $domain = 'public'; //图片domain名称   
            $s = new SaeStorage();  
            //获得文件扩展名
            $file_name = $_FILES['video']['name'];
            //服务器上临时文件名
            $tmp_name = $_FILES['video']['tmp_name'];
            $temp_arr = explode(".", $file_name);
            $file_ext = array_pop($temp_arr);
            $file_ext = trim($file_ext);
            $file_ext = strtolower($file_ext);
            date_default_timezone_set("Asia/Shanghai");
            $ymd = date('Ymd');
            //新文件名
            $new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
            //文件存储路径  
            $new_file_name = 'upload/' . $ymd . "/" . $new_file_name;  
              
            $r = $s->upload( $domain , $new_file_name , $tmp_name);   
            $img_url =  $s->getUrl( $domain , $new_file_name);      
            exit(json_encode(array('s'=>0,'msg'=>'上传成功','url'=>$img_url)));
        }else{ 
               $savePath =  './Public/upload/image'.'/'.date('y').'/'.date('md').'/';// 设置附件上传目录
               //目录不存在创建目录【递级】
               if(!is_dir('./Public/upload/image'.'/'.date('y').'/')){
                       @mkdir('./Public/upload/image'.'/'.date('y').'/', 0755);
                       @fclose();
                   }
              //目录不存在创建目录【递级】
               if(!is_dir($savePath)){
                    @mkdir($savePath, 0755);
                    @fclose();
               }
              import('ORG.Net.UploadFile');
              $upload = new UploadFile();// 实例化上传类
              $upload->maxSize  = 10000000;//10M，php.ini需配置
              //$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
              $upload->savePath =  $savePath;// 设置附件上传目录
               if(!$upload->upload()) {// 上传错误提示错误信息
                   exit(json_encode(array('s'=>1,'msg'=>$upload->getErrorMsg(),'url'=>'')));
               }else{// 上传成功 获取上传文件信息
                   $info =  $upload->getUploadFileInfo();
               }
               $img = $upload->savePath.$info[0]['savename']; // 保存上传的附件根据需要自行组装
               $img_url = C('SITE_URL').'/'.ltrim($img, './');
               exit(json_encode(array('s'=>0,'msg'=>'上传成功','url'=>$img_url)));
             }
        }              
}