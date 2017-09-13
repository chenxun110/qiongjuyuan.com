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
	<li <?php if((MODULE_NAME == 'Member')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Member/index');?>">多媒体资料</a></li>
	</ul>	
	 <ul class="nav nav-tabs nav-stacked">
	 <li class="header"><a href="javascript:void(0);"><i class="icon-plus" ></i>互动分享</a></li>
	  <li <?php if((MODULE_NAME == 'Member')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Member/index');?>">用户中心</a></li>
	  <li <?php if((MODULE_NAME == 'Interact')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Interact/index');?>">互动平台</a></li>	
	 </ul>	
	
	<ul class="nav nav-tabs nav-stacked">
		<li class="header"><a href="javascript:void(0);"><i class="icon-plus" ></i>网上订票</a></li>
		 <li <?php if((MODULE_NAME == 'Order')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Order/index');?>">剧目管理</a></li>	
		 <li <?php if((MODULE_NAME == 'Order')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Order/index');?>">座位管理</a></li>
		 <li <?php if((MODULE_NAME == 'Order')): ?>class="cur"<?php endif; ?>><a href="<?php echo U(GROUP_NAME.'/Order/index');?>">订单管理</a></li>
	</ul>
    </div>
</div>
<!-- sidebar -->
<!-- main -->
<div class="main span10">
<div class="btn-group pull-right">
<a href="<?php echo U(GROUP_NAME.'/Club/add');?>" class="btn btn-success"><i class="icon-plus icon-white"></i> 添加</a>
</div>
<h4>院团名角介绍</h4>
<hr/>
  <table class="table table-bordered table-wordpress postlist-table">
    <thead>

      <tr>
        <th>编号</th>
        <th>标题</th>
        <th>添加时间</th>
        <th>操作</th>
      </tr>
    </thead>
    <tbody>
        <?php if(is_array($list)): foreach($list as $key=>$list): ?><tr class="tr-publish">
        <td><?php echo $list['id'];?></td>
        <td><?php echo $list['title'];?></td>
        <td><?php echo (date('Y-m-d H:i:s',$list['addtime'])); ?></td>
      
        <td>
          <div class="btn-toolbar">
            <div class="btn-group">
              <a href="<?php echo U(GROUP_NAME.'/Club/edit',array('id'=>$list['id']));?>" class="btn btn-mini" ><i class="icon-edit"></i> 更改</a>
              <a href="javascript:void(0);" class="btn btn-mini btn-danger" onclick="confirm('确定要删除吗？', function(){del(<?php echo $list['id']; ?>)})"><i class="icon-remove"></i> 删除</a>
            </div>
          </div>
        </td>
      </tr><?php endforeach; endif; ?>
        
    </tbody>
  </table>
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