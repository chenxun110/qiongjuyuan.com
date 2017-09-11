<?php
/**
 * 接口
 * author jasxun
 * date 2015-11-7
 * link jasxun.sinaapp.com
 */
class IndexAction extends Action{
//首页	
 public function index(){
 
 }
 //【新增】同步数据
 public function add_news(){
 	if(IS_POST){
 		if(!$_POST['title']){
 			echo json_encode(array('status'=>1,'msg'=>'请输入标题'));exit();
 		}
		   $data['title'] = $_POST['title'];
		   $data['discription'] = $_POST['discription'];
		   $data['thumb'] = $_POST['thumb'];
		   $data['content'] = $_POST['content'];
		   $data['cate_id'] = 2;
		   $data['addtime'] = time();
		   $insert_id = M('article')->add($data);
		   if($insert_id>0){
		   	 echo json_encode(array('status'=>0,'msg'=>'success','id'=>$insert_id,'content'=>$_POST['content']));
		   }else{
		   	 echo json_encode(array('status'=>1,'msg'=>'fail'));
		   }	
   }else{
   	 echo json_encode(array('status'=>1,'msg'=>'fail'));
   }
 }
 //【编辑】同步数据
 public function edit_news(){
 	if(IS_POST){
 			if(empty($_POST['id'])){
 				echo json_encode(array('status'=>1,'msg'=>'fail'));exit();
 			}
 		  $data['title'] = $_POST['title'];
 		  $data['discription'] = $_POST['discription'];
 		  $data['thumb'] = $_POST['thumb'];
 		  $data['content'] = $_POST['content'];
 		  $data['id'] = $_POST['id'];
 		  $aff_id = M('article')->save($data);
 		  if($aff_id!==false){
 		  	 echo json_encode(array('status'=>0,'msg'=>'success'));
 		  }else{
 		  	 echo json_encode(array('status'=>1,'msg'=>'fail'));
 		  }	 
 	}
 	
 }
 //【删除】同步数据
 public function delete_news(){
 	if(IS_POST){
	 	if(empty($_POST['id'])){
	 		echo json_encode(array('status'=>1,'msg'=>'fail'));exit();
	 	};
	   $insert_id = M('article')->where(array('id'=>$_POST['id']))->delete();
	   if($insert_id>0){
	   	 echo json_encode(array('status'=>0,'msg'=>'success'));
	   }else{
	   	 echo json_encode(array('status'=>1,'msg'=>'fail'));
	   }	
   }
 }

  //【列表】同步数据
 public function get_news_list(){
   $list = M('article')->where(array('cate_id'=>2))->order('id desc')->select();
   echo json_encode(array('status'=>0,'msg'=>'success','newslist'=>$list));
 }
  //【记录】同步数据
 public function get_news_find(){
 	if(IS_POST){
 		$data = M('article')->where(array('id'=>$_POST['id']))->find();
 		echo json_encode(array('status'=>0,'msg'=>'success','news'=>$data));
 	}
 }
 //ajax上传附件【后台上传apk】
  public function uploadify(){
      header('Content-Type:text/html; charset=utf-8');
      import('ORG.Net.UploadFile');
      $upload = new UploadFile();// 实例化上传类
      $upload->maxSize  = 3000000000;//php.ini需配置
      $upload->allowExts  = array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb', 'mp4');// 设置附件上传类型
      $upload->uploadReplace  = false;// 存在同名是否覆盖
      $savePath = './Public/file/'.time();// 设置附件上传目录
      $upload->savePath =  $savePath;
      if(!is_dir('./Public/file')){
          @mkdir('./Public/file', 0755);
          @fclose();
      }
      if(!is_dir($upload->savePath))
      {
          @mkdir($upload->savePath, 0755);
          @fclose();
      }
      
      if(!$upload->upload()) {// 上传错误提示错误信息
          exit(json_encode(array('s'=>1,'msg'=>$upload->getErrorMsg(),'url'=>'')));
      }else{// 上传成功 获取上传文件信息
          $info =  $upload->getUploadFileInfo();
      }
      $file = $upload->savePath.$info[0]['savename']; // 保存上传的附件根据需要自行组装
      $file_url = C('SITE_URL').'/'.ltrim($file, './');
      exit(json_encode(array('s'=>0,'msg'=>'上传成功','url'=>$file_url)));
  }
}