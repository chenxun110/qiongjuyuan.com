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
<script src="__PUBLIC__/uploadify/jquery.uploadify.min.js" type="text/javascript"></script>
  <script type="text/javascript">
  $(function(){
    $(".cancel").die().live("click",function(){
        $(this).parent(".House").remove();
      });
  });
  </script>
<style type="text/css">
.House{
  float: left;
  width: 140px;
  height: 100px;
  margin: 8px;
}
.House img{
  float: left;
  width: 100px;
  height: 60px;
  border:1px; 
  background: #fff;
  border:1px solid #666;
  padding: 6px;
}
.House a{
  display: block;
  width: 100px;
  display: 30px;
  line-height: 30px;
  text-align: center;
}
.file_upload{
  margin-top:10px;
  clear: both;
}
</style>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/uploadify/uploadify.css">
<!-- main -->
<div class="main span10">
    <h4>编辑<a href="<?php echo U(GROUP_NAME.'/Videocate/index');?>" class="pull-right" ><i class="icon-backward"></i> <strong>返回列表</strong></a></h4>
<hr>
    <form action="<?php echo U(GROUP_NAME.'/Videocate/update');?>" method="post" accept-charset="utf-8" class="well form-inline" id="f" onSubmit="return qjy_ajaxform(this,function(d){opt_ok_return(d)})"> 
      <table class="table table-bordered table-wordpress postlist-table">
        <tbody>
          
        <tr>
          <td width="25%"><label for="title">栏目名称<font color="red">*</font></label></td>
          <td><input type="text" name="subject" value="<?php echo $vo['subject'];?>" id="subject" class="span4"/></td>
        </tr> 
            <?php $adv = explode(',',$vo['adv']); ?>
            <tr><td>
            <label for="title">幻灯片</label></td>
            <td><div id="xmzb">
             <?php if(!empty($vo['adv'])){ ?>
              <?php if(is_array($adv)): foreach($adv as $key=>$list): ?><div class='House'>
                <img class='uploadifyimg' src='<?php echo $list;?>' style='margin-left:15px;margin-top:15px'/>
                <input type='hidden' name='adv[]'  value='<?php echo $list;?>'><a class='cancel' href='javascript:void(0);'>删除</a>
              </div><?php endforeach; endif; ?>
              <?php } ?>
            </div>
        </td>
          </tr>
          <tr><td></td>
                     <td><input id="xmzb_upload" name="xmzb_upload" class="file_upload" type="file" multiple="true"></td>
             <td>
             </tr> 
        <tr><td></td>
        <td><input name="id" value="<?php echo $vo['id'];?>" type="hidden">
          <input type="submit" value="保存" id="submit" class="btn btn-large btn-success"  /></td>
       </tr>
        </tbody>
    </table>
        
    </form>
</div>
  <script type="text/javascript">
    <?php $timestamp = time();?>
    $(function() {
      $('#xmzb_upload').uploadify({
        'formData'     : {
          '<?php echo session_name();?>' : '<?php echo session_id();?>', //此处获取SESSIONID
          'timestamp' : '<?php echo $timestamp;?>',
          'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
        },
        'swf'      : '__PUBLIC__/uploadify/uploadify.swf',
        'buttonText':'选择图片',
        'uploader' : '__PUBLIC__/uploadify/uploadify.php',
        'onUploadSuccess' : function(file, data, response) {
          var jsonObject = jQuery.parseJSON(data);
          var str=$('#xmzb').html();
            var add="<div class='House'><img class='uploadifyimg' src='"+jsonObject.msg+"' style='margin-left:15px;margin-top:15px'/><input type='hidden' name='adv[]'  value='"+jsonObject.msg+"'><a class='cancel' href='javascript:void(0);'>删除</a></div>";
            str+=add;
         $('#xmzb').html(str);
        },
      });
    });
  </script>
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