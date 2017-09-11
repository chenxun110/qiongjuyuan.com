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
<!-- main -->
<div class="main span10">
<div class="btn-group pull-right">
<a href="<?php echo U(GROUP_NAME.'/Videocate/add');?>" class="btn btn-success"><i class="icon-plus icon-white"></i> 添加</a>
</div>
<h4>视频分类</h4>
<hr/>
  <table class="table table-bordered table-wordpress postlist-table">
    <thead>

      <tr>
        <th>编号</th>
        <th>栏目名称</th>
        <th>类型</th>
        <th>操作</th>
      </tr>
    </thead>
    <tbody>
        <?php if(is_array($list)): foreach($list as $key=>$list): ?><tr class="tr-publish">
        <td><?php echo $list['id'];?></td>
        <td><?php echo $list['subject'];?></td>
        <td><?php if($list['type'] == 0): ?>视频<?php elseif($list['type'] == 1): ?>音频<?php endif; ?></td>
        <td>
          <div class="btn-toolbar">
            <div class="btn-group">
              <a href="<?php echo U(GROUP_NAME.'/Videocate/edit',array('id'=>$list['id']));?>" class="btn btn-mini" ><i class="icon-edit"></i> 更改</a>
              <a href="javascript:void(0);" class="btn btn-mini btn-danger" onclick="confirm('确定要删除吗？', function(){del(<?php echo $list['id']; ?>)})"><i class="icon-remove"></i> 删除</a>
            </div>
          </div>
        </td>
      </tr><?php endforeach; endif; ?>
        
    </tbody>
  </table>
    <?php echo $page;?>
</div>
  
<script type="text/javascript">
 function status(id){
   $.post("<?php echo U(GROUP_NAME.'/Videocate/ajax_status');?>",{'id':id},function(data){
        if(data.status==1){
           $("#status_"+id).html(data.html);
        }

   });
 }

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