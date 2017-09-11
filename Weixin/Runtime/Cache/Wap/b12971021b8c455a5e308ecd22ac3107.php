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
    <div class="article-title">
        <h2><?php echo $data['title'];?></h2>
      </div> 
    <div class="performer-article clearfix">
      <div class="performer-img">
        <img src="<?php echo $data['thumb'];?>" />
      </div>
      <!-- 名角个人图片,缩略图?） -->
      <?php echo $data['content'];?>
    </div>
    <!-- 下面应该是跳去新页面? -->
    <div class="view-audio-wrap">
      <?php if($data['video_id'] != 0): ?><a href="<?php echo U('Wap/Artice/video',array('id'=>$data['video_id']));?>" class="media-btn">
        <button class="btn btn-success" type="button">
          <i class="fa fa-video-camera"></i>
        </button>
        <p>视频</p>
      </a><?php endif; ?>
     <?php if($data['audio_id'] != 0): ?><a href="<?php echo U('Wap/Artice/audio',array('id'=>$data['audio_id']));?>" class="media-btn">
        <button class="btn btn-success" type="button">
          <i class="fa fa-tripadvisor"></i>
        </button>
        <p>音频</p>
      </a><?php endif; ?>
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