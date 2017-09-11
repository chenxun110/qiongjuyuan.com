<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>琼剧院微信平台</title>
<link href="__CSS__/bootstrap.css" rel="stylesheet" />
<link href="__CSS__/font-awesome.css" rel="stylesheet" />
<link href="__CSS__/admin.css" rel="stylesheet" />
<script src="__JS__/jquery.js"></script>
<script src="__JS__/bootstrap.min.js"></script>
<script src="__JS__/common.js"></script>
</head>
<body>
<!-- header -->
<div class="header navbar navbar-fixed-top navbar-inverse" style="background:#44b549;">
	<div class="navbar-inner" style="background:#44b549;border-color:#44b549;">
		<div class="container-fluid">
			<a class="brand" href="<?php echo U(GROUP_NAME.'/Index/index');?>" style="color:#fff;">琼剧院微信平台</a>
			<ul class="nav pull-right">
				
				<?php if($_SESSION['token'] != ''): ?><li><a style="color:#fff;" href="javascript:void(0);">当前：<?php echo session('wxname');?></a>
				</li><?php endif; ?>
				<li><a style="color:#fff;" href="<?php echo U(GROUP_NAME.'/Article/index');?>"><i class="icon-home"></i>海南省琼剧院</a></li>
				<li><a style="color:#fff;" href="<?php echo U(GROUP_NAME.'/Video/index');?>"><i class="icon-film"></i>琼剧赏析</a></li>
				<li><a style="color:#fff;" href="<?php echo U(GROUP_NAME.'/Schedule/index');?>"><i class="icon-road"></i>演出及动态</a></li>
				<!--
				<li><a style="color:#fff;" href="<?php echo U(GROUP_NAME.'/Order/index');?>"><i class="icon-home"></i>微信预定</a></li>
				<li><a style="color:#fff;" href="<?php echo U(GROUP_NAME.'/Interact/index');?>"><i class="icon-home"></i>互动平台</a>
				</li>-->
				<li><a style="color:#fff;" href="<?php echo U(GROUP_NAME.'/Member/index');?>"><i class="icon-user"></i>用户管理</a>
				</li>
				<li><a style="color:#fff;" href="<?php echo U(GROUP_NAME.'/Index/changepassword');?>"><i class="icon-key"></i>修改密码</a>
				</li>
                <li><a style="color:#fff;" href="<?php echo U(GROUP_NAME.'/Index/logout');?>"><i class="icon-off" ></i>安全退出</a></li>
			</ul>
		</div>
	</div>
</div>
<!-- header -->
<div class="container-fluid">
	<!-- row-fluid -->
	<div class="row-fluid wrap">
		<!-- sidebar -->
<div class="span2 sidebar">
	<div class="menu">
	<ul class="nav nav-tabs nav-stacked">
		<li class="header"><a href="javascript:void(0);"><i class="icon-plus" ></i>公众号管理</a></li>	
		<li <?php if((MODULE_NAME == 'Wxuser') or (MODULE_NAME == 'Index')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Wxuser/set');?>">公众号设置</a></li>
		<li <?php if((MODULE_NAME == 'Menu')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Menu/index');?>">自定义菜单</a></li>
		<li <?php if((MODULE_NAME == 'Wxuser')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Wxuser/welcome');?>">关注时回复</a></li>	
		<li <?php if((MODULE_NAME == 'Replynews')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Replynews/index');?>">单图文管理</a></li>
		<li <?php if((MODULE_NAME == 'Muti')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Muti/index');?>">多图文管理</a></li>	
		<li <?php if((MODULE_NAME == 'Keyword')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Keyword/index');?>">关键词维护</a></li>		
	</ul>
	<ul class="nav nav-tabs nav-stacked">
	<li class="header"><a href="javascript:void(0);"><i class="icon-plus" ></i>海南省琼剧院</a></li>	
	 <li <?php if((MODULE_NAME == 'Article')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Article/index');?>">琼剧概况</a></li>
	  <li <?php if((MODULE_NAME == 'Club')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Club/index');?>">院团名角介绍</a></li>
	  <li <?php if((MODULE_NAME == 'Zwgk')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Zwgk/index');?>">政务公开</a></li>
	  <!--<li <?php if((MODULE_NAME == 'About')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/About/index');?>">关于我们</a></li>	-->
	</ul>	
	 <ul class="nav nav-tabs nav-stacked">
	 <li class="header"><a href="javascript:void(0);"><i class="icon-plus" ></i>用户管理</a></li>
	  <li <?php if((MODULE_NAME == 'Member')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Member/index');?>">用户管理</a></li>
	  <!--<li <?php if((MODULE_NAME == 'Interact')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Interact/index');?>">互动平台</a></li>	-->
	 </ul>	
	<ul class="nav nav-tabs nav-stacked">
	<li class="header"><a href="javascript:void(0);"><i class="icon-plus" ></i>琼剧赏析</a></li>
	 <li <?php if((MODULE_NAME == 'Videocate')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Videocate/index');?>">视频分类</a></li>
	 <li <?php if((MODULE_NAME == 'Video')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Video/index');?>">视频管理</a></li>
	 <li <?php if((MODULE_NAME == 'Audiocate')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Audiocate/index');?>">音频分类</a></li>	
	 <li <?php if((MODULE_NAME == 'Audio')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Audio/index');?>">音频管理</a></li>	
		
	</ul>		
	<ul class="nav nav-tabs nav-stacked">
		<li class="header"><a href="javascript:void(0);"><i class="icon-plus" ></i>演出及动态</a></li>	
		 <li <?php if((MODULE_NAME == 'Schedule')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Schedule/index');?>">演出排期</a></li>
		 <li <?php if((MODULE_NAME == 'News')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/News/index');?>">琼剧动态</a></li>
		  <!--<li <?php if((MODULE_NAME == 'Order')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Order/index');?>">微信预定</a></li>-->
	</ul>
	  <!--<ul class="nav nav-tabs nav-stacked">
		<li class="header"><a href="javascript:void(0);"><i class="icon-plus" ></i>优惠劵管理</a></li>	
		<li <?php if((MODULE_NAME == 'Discount')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Discount/index');?>">优惠劵管理</a></li>
		<li <?php if((MODULE_NAME == 'DiscountOrder')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/DiscountOrder/index');?>">优惠劵领取</a></li>
	</ul>	-->	
    </div>
</div>

<script type="text/javascript">
$(function(){ 
 $(".cur").parent().find('li').show();
 $(".cur").parent('ul').siblings('ul').find('li:not(.header)').hide();
  $(".menu .header").click(function(){
  	if($(this).siblings().css("display")=='none'){
  		$(this).find('i').removeClass('icon-plus');
  		$(this).find('i').addClass('icon-minus');
       $(this).parent().find('li').show();
       $(this).parent('ul').siblings('ul:last-child').find('li:not(.header)').show();
  	}else{
  	  $(this).find('i').removeClass('icon-minus');
  	  $(this).find('i').addClass('icon-plus');
      $(this).parent().find('li:not(.header)').hide();
      $(this).parent('ul').siblings('ul:last-child').find('li:not(.header)').show();
  	}
       
  });
  $(".menu .header").parent('ul').siblings('ul:last-child').find('li:not(.header)').show();
   $(".menu .header").each(function(){
    if($(this).siblings().css("display")!='none'){
      $(this).find('i').removeClass('icon-plus');
      $(this).find('i').addClass('icon-minus');	
    }
   });


});

</script>
<!-- sidebar -->
<style type="text/css">
.appmsg_content {
    padding: 0 14px;
    position: relative;
}
.appmsg {
    background-color: #fff;
    border: 1px solid #e7e7eb;
    color: #666;
    margin-bottom: 20px;
    overflow: hidden;
    position: relative;
    height: 352px;
}
appmsg_item:after {
    clear: both;
    content: "​";
    display: block;
    height: 0;
}
.appmsg_item {
    border-top: 1px solid #e7e7eb;
    padding: 20px 14px;
    position: relative;
}
.cover_appmsg_item {
    margin: 0 14px 14px;
    position: relative;
}
.appmsg_thumb {
    float: right;
    margin-left: 14px;
    min-width: 100%;
}
.cover_appmsg_item .appmsg_title {
    background: none repeat scroll 0 0 rgba(0, 0, 0, 0.6) !important;
    bottom: 0;
    left: 0;
    position: absolute;
    width: 100%;
}
.appmsg_title {
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: 28px;
    max-height: 56px;
    overflow: hidden;
    padding-top: 10px;
    word-break: break-all;
    word-wrap: break-word;
}

.appmsg_opr {
    background-color: #f4f4f4;
    border-top: 1px solid #e7e7eb;
}
.appmsg_opr_item {
    float: left;
    height: 44px;
    line-height: 44px;
}
.size1of2 {
    width: 50%;
}
ul, ol {
    list-style-type: none;
}
.appmsg {
    color: #666;
}
.appmsg_list .tj_item {
    font-size: 14px;
    text-align: left;
}
input, textarea, button, a {
    outline: 0 none;
}
.cover_appmsg_item .appmsg_title a {
    color: #fff;
    padding: 0 8px;
}
.appmsg_info {
    padding-left: 14px;
    padding-right: 14px;
    padding-top: 14px;
}
.appmsg_info {
    font-size: 13px;
    line-height: 20px;
    padding-bottom: 10px;
}
.appmsg_list .tj_item {
    font-size: 14px;
    text-align: left;
}
.appmsg_title a {
    color: #666;
    display: block;
}
a {
    color: #459ae9;
    text-decoration: none;
}
input, textarea, button, a {
    outline: 0 none;
}

.appmsg_thumb_wrp {
    height: 160px;
    overflow: hidden;
}
.appmsg_item {
    border-top: 1px solid #e7e7eb;
    padding: 20px 14px;
    position: relative;
}
</style>
<!-- main -->
<div class="main span10">
<div class="btn-group pull-right">
<a href="<?php echo U(GROUP_NAME.'/Replynews/add');?>" class="btn btn-success"><i class="icon-plus icon-white"></i> 添加图文</a>
</div>
<h4>单图文列表</h4>
<hr>
  <?php if(is_array($list)): foreach($list as $key=>$list): ?><div class="span3">
    <div class="appmsg ">
         <div class="appmsg_content">
        
            <h4 class="appmsg_title"><a target="_blank" href="javascript:void(0);"><?php echo str_cut($list['title'],100);?></a></h4>
            <div class="appmsg_info"><em class="appmsg_date"><?php echo (date('m月d日',$list['addtime'])); ?></em></div>
            <div class="appmsg_thumb_wrp">
              <img class="appmsg_thumb" alt="" src="<?php echo ($list['picurl']); ?>"></div>
            <p class="appmsg_desc"><?php echo msubstr($list['description'],0,30,'utf-8',true);?></p>
        
    </div>
    <div class="appmsg_opr">
        <ul>
            <li class="appmsg_opr_item grid_item size1of2">
            <a  href="<?php echo U(GROUP_NAME.'/Replynews/edit',array('id'=>$list['id']));?>" >编辑</i></a>
            </li>
            <li class="appmsg_opr_item grid_item size1of2 no_extra">
                <a onclick="confirm('确定要删除吗？', function(){del(<?php echo $list['id']; ?>)})" href="javascript:void(0);">删除</i></a>
            </li>
        </ul>
    </div>
  </div>
</div><?php endforeach; endif; ?>
</div>
  <div class="span8">
  <?php echo $page;?>
</div>
<!-- main -->
</div>
<!-- row-fluid -->
</div>
<script>
  function del(id){
     var url = "<?php echo U(GROUP_NAME.'/'.$module_name.'/delete');?>";
     $.post(url,{id:id},function(data){
       ys_tips({w:data.msg,t:0,url:data.url});
        },"JSON"); 
  }
</script>
<div class="footer">
  <div class="footer_message container">
	  <span>技术支持：249543262</span>
	  <span><a href="http://www.weibo.com/jasxun">新浪微博</a></span>
	  <span style="margin-left:10px;">微信公众号：jasxun</span>
	  <span style="margin-left:10px;">微信号：jas-xun</span>
	  <p style="padding-left: 5px;">2005 - 2016 @版权所有</p>
  </div>
</div>
</body>
</html>