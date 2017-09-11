<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" type="text/css" href="__CSS__libs/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="__CSS__libs/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css" />
  <link rel="stylesheet" type="text/css" href="__CSS__libs/plugins/font-awesome/css/font-awesome.min.css" />
  <link rel="stylesheet" type="text/css" href="__CSS__libs/css/app.css" />
  <link rel="stylesheet" type="text/css" href="__CSS__libs/plugins/swiper/css/swiper.min.css" />
  <!--[if lte IE 9]>
    <script src="__CSS__libs/bootstrap/respond.min.js"></script>
    <script src="__CSS__libs/bootstrap/html5shiv.min.js"></script>
    <![endif]-->
  <title><?php echo $data['title'];?></title>
</head>
<body>
  <div class="app-wrap container">
    <div class="video-content">
      <div class="video-box">
       <video id="video" controls="" preload="none" mediagroup="myVideoGroup" poster="<?php echo $data['thumb'];?>">
         <source id="mp4" src="<?php echo $data['url'];?>" type="video/mp4">
          <!--<source id="webm" src="http://media.w3.org/2010/05/sintel/trailer.webm" type="video/webm">-->
        <!--  <source id="ogv" src="http://media.w3.org/2010/05/sintel/trailer.ogv" type="video/ogg">-->
         <p>Your user agent does not support the HTML5 Video element.</p>
       </video>
       <!-- 必须加在微信api资源 -->
       <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
       <script>
            //一般情况下，这样就可以自动播放了，但是一些奇葩iPhone机不可以
           
           //必须在微信Weixin JSAPI的WeixinJSBridgeReady才能生效
           document.addEventListener("WeixinJSBridgeReady", function () {
           document.getElementById('video').play();
           }, false);
       </script>
        
        <!--<video src="<?php echo $data['url'];?>" controls="controls">
          您的浏览器不支持此类播放器
        </video>-->
      </div>
      <h4 class="video-bar">《<?php echo $data['title'];?>》 时长:<?php echo $data['length'];?></h4>
      <div class="video-info">
      <?php echo $data['content'];?>
        <div class="more-down js_more_descrition"><i class="fa fa-chevron-down"></i></div>
      </div>
    </div>
    <h4 class="video-bar">我要评论</h4>
    <form method="post" class="js_comment_form" action="<?php echo U('Wap/Artice/commit');?>">
      <div class="form-group">
        <textarea class="form-control" name="content"></textarea>
        <input name="type_id" value="1" type="hidden">
        <input name="cid" value="<?php echo $data['id'];?>" type="hidden">
      </div>
      <div class="flex">
        <div class="flex-item plr10"><button type="reset" class="btn btn-default full-control">清空</button></div>
        <div class="flex-item plr10"><button type="submit" class="btn btn-success full-control">发表</button></div>
      </div>
    </form>
    <h4 class="video-bar">精彩评论</h4>
    <div class="comments">
      <?php if(is_array($list)): foreach($list as $key=>$list): ?><div class="comment-item">
        <div class="u-img">
          <img src="<?php echo (($list['headerpic'])?($list['headerpic']):'__CSS__photo/2.jpg'); ?>" />
        </div>
        <div class="comment-info">
          <div class="comment-body">
            <div class="comment-author clearfix">
              <div class="u-name fl"><?php echo $list['wxname'];?></div>
              <div class="dates fr"><?php echo (date('Y-m-d',$list['addtime'])); ?></div>
            </div>
            <div class="comment-say">
              <?php echo $list['content'];?>
            </div>
          </div>
        </div>
      </div><?php endforeach; endif; ?>
      <div class="more-down js_more_comments"><i class="fa fa-chevron-down"></i></div>
    </div>
  </div>
<!-- 会员注册modal -->
<div class="modal fade" id="userReg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body user-reg">
        <h3>请先注册成为会员</h3>
        <form action="<?php echo U('Wap/Artice/register');?>" class="js_reg_form" method="post">
          <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="请输入您的昵称">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="mobile" placeholder="请输入您的手机号码">
          </div>
          <div class="form-group">
            <label class="radio-inline">
              <input type="radio" name="sex" value="1" checked="checked"> 男
            </label>
            <label class="radio-inline">
              <input type="radio" name="sex" value="2"> 女
            </label>
          </div>
          <button type="submit" class="btn btn-success">注册</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- 底部菜单 -->
<!-- 
<div class="footer">
  <ul class="footer-nav flex">
    <li class="flex-item"><a href="<?php echo U('/Wap/booking/');?>"><i class="fa fa-home"></i>首页</a></li>
    <li class="flex-item"><a href="/index.php/wap/member/postbbs.html"><i class="fa fa-edit"></i>发表</a></li>
    <li class="flex-item"><a href="<?php echo U('/Wap/Member/bbs');?>"><i class="fa fa-commenting"></i>互动</a></li>
    <li class="flex-item"><a href="/index.php/wap/member/index.html"><i class="fa fa-user"></i>我的</a></li>
  </ul>
</div>
 -->
<script type="text/javascript" src="__CSS__libs/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="__CSS__libs/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="__CSS__libs/plugins/jqPaginator.min.js"></script>
<script type="text/javascript" src="__CSS__libs/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="__CSS__libs/bootstrap-datetimepicker/locales/bootstrap-datetimepicker.fr.js"></script>
<script type="text/javascript" src="__CSS__libs/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="__CSS__libs/plugins/layer/layer.js"></script>
<script type="text/javascript" src="__CSS__libs/plugins/swiper/js/swiper.jquery.js"></script>
<script type="text/javascript" src="__CSS__libs/plugins/plupload/plupload.full.min.js"></script>
<script type="text/javascript" src="__CSS__libs/plugins/jquery.lazyload.min.js"></script>
<script type="text/javascript" src="__CSS__libs/app.js"></script>
</body>
</html>