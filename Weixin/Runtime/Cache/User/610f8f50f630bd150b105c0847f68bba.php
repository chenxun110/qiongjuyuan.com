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
	<li class="header"><a href="javascript:void(0);"><i class="icon-plus" ></i>琼剧相关</a></li>	
	<li <?php if((MODULE_NAME == 'Article')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Article/index');?>">琼剧概况</a></li>
	<li <?php if((MODULE_NAME == 'Club')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Club/index');?>">院团和名角</a></li>
	<li <?php if((MODULE_NAME == 'About')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/About/index');?>">关于我们</a></li>
	<li <?php if((MODULE_NAME == 'News')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/News/index');?>">戏曲新闻</a></li>
	<li <?php if((MODULE_NAME == 'Member')): ?>class="cur"<?php endif; ?>><a href="">多媒体资料</a></li>
	</ul>	
	 <ul class="nav nav-tabs nav-stacked">
	 <li class="header"><a href="javascript:void(0);"><i class="icon-plus" ></i>互动分享</a></li>
	  <li <?php if((MODULE_NAME == 'Member')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Member/index');?>">用户中心</a></li>
	  <li <?php if((MODULE_NAME == 'Interact')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Interact/index');?>">互动平台</a></li>	
	 </ul>	
	
	<ul class="nav nav-tabs nav-stacked">
		<li class="header"><a href="javascript:void(0);"><i class="icon-plus" ></i>网上订票</a></li>
		 <li <?php if((MODULE_NAME == 'Order')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/schedule/index');?>">琼剧排期</a></li>	
		 <li <?php if((MODULE_NAME == 'Order')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Place/index');?>">座位管理</a></li>
		 <li <?php if((MODULE_NAME == 'Order')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Booking/index');?>">订单管理</a></li>
	</ul>
    </div>
</div>
<!-- sidebar -->
<link rel="stylesheet" href="__PUBLIC__/kindeditor-4.1.7/themes/default/default.css" />
<script src="__PUBLIC__/kindeditor-4.1.7/kindeditor.js"></script>
<script src="__PUBLIC__/kindeditor-4.1.7/lang/zh_CN.js"></script>
    <script>
      KindEditor.ready(function(K) {
        var editor = K.editor({
          allowFileManager : true,
          urlType:'domain',
          afterBlur : function(){  
                    //编辑器失去焦点时直接同步，可以取到值  
                    this.sync();  
                }  
        });
        K('#upload').click(function() {
          editor.loadPlugin('image', function() {
            editor.plugin.imageDialog({
              showRemote : false,
              imageUrl : K('#headpic').val(),
              clickFn : function(url, title, width, height, border, align) {
                var url = "<?php echo C('SITE_URL');?>"+url;
                K('#headpic').val(url);
                K('#pic').attr('src',url);
                editor.hideDialog();
              }
            });
          });
        });
      });
    </script>
<!-- main -->
<div class="main span10">
  <h4>公众号配置</h4>
  <hr/>
      <div class="alert alert-success">
      url:<strong><?php echo C('SITE_URL');?>/weixin</strong><br/>
      token:<strong><?php echo C('TOKEN');?></strong>
      </div>
    <form action="<?php echo U(GROUP_NAME.'/Wxuser/set');?>" method="post" accept-charset="utf-8" class="well form-inline" id="f" onSubmit="return qjy_ajaxform(this,function(d){opt_ok_return(d)})"> 
      <table class="table table-bordered table-wordpress postlist-table">
        <tbody>
          
        <tr>
          <td width="25%"><label for="title">公众号名称<font color="red">*</font></label></td>
          <td><input type="text" name="wxname" value="<?php echo $vo['wxname'];?>" id="wxname" class="span4"/></td>
        </tr> 
        <tr>
          <td><label for="title">公众号原始id<font color="red">*</font></label></td>
          <td><input type="text" name="wxid" value="<?php echo $vo['wxid'];?>" id="wxid" class="span4"/></td>
        </tr>   
        <tr>
        <td><label for="title">公众号类型<font color="red">*</font></label></td>
          <td>
          <input name="type" <?php if($vo['type'] == 0): ?>checked="checked"<?php endif; ?> value="0" type="radio">订阅号
          <input name="type" <?php if($vo['type'] == 1): ?>checked="checked"<?php endif; ?> value="1" type="radio">服务号
        </td>
        </tr> 
         <tr>
          <td><label for="title">AppId<font color="red">*</font></label></td>
          <td><input type="text" name="AppId" value="<?php echo $vo['AppId'];?>" id="AppId" class="span4"/></td>
        </tr> 
         <tr>
          <td><label for="title">Secret<font color="red">*</font> </label></td>
          <td><input type="text" name="Secret" value="<?php echo $vo['Secret'];?>" id="Secret" class="span8"/></td>
        </tr>
        <tr><td></td>
        <td><input name="id" value="<?php echo $vo['id'];?>" type="hidden">
          <input type="submit" value="保存" id="submit" class="btn btn-large btn-success"  /></td>
       </tr>
        </tbody>
    </table>
        
    </form>
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