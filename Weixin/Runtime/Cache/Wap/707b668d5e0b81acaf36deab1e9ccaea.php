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
  <title>订票</title>
</head>
<body>
  <div class="app-wrap container notUser"><!-- 用户若没有注册，请在此添加一个class:notUser -->
    <div class="book-ticket mb5">
      <div class="ticket-info-item">
        <h4>《<?php echo $data['title'];?>》</h4>
      </div>
      <div class="ticket-info-item">
        时间：<?php echo (date('m月d日',$data['start_time'])); ?>-<?php echo (date('m月d日',$data['end_time'])); ?>
      </div>
    </div>
    <ul class="ticket-book-form flex"> 
      <li class="flex-item">

        <div class="ticket-chip">
          <span class="price">&yen;<?php echo $price_content[0]['price'];?></span>
        </div>
        <div class="ticket-chip">
          <?php echo $price_content[0]['title'];?>排
        </div>
        <div class="ticket-chip">
           <?php $num_one = $price_content[0]['num']-get_type_piao($data['id'],1); ?>
           <span <?php if($num_one == 0): ?>class="gray-font"<?php endif; ?>>余票:<span class="js_remainder"><?php echo $num_one;?></span></span><!-- 若无票 按钮增加class选择符:gray-font -->
        </div>
        <form class="js_book_ticket_form" action="<?php echo U('Wap/Booking/order');?>" method="post">
        <div class="ticket-chip">
          <div class="ticket-buy-num" data-count="<?php echo $num_one;?>">
            <i class="fa fa-minus js_minus_num"></i>
            <input type="text" name="num" value="1" />
            <!--票数X数量，计算价格-->
            <input type="hidden" name="price" value="<?php echo $price_content[0]['price'];?>">
            <input type="hidden" name="type_id" value="1">
            <input type="hidden" name="id" value="<?php echo $data['id'];?>">

            <i class="fa fa-plus js_plus_num"></i>
          </div>
        </div>
        <div class="ticket-chip"><!-- 若无票 按钮增加 disabled -->
          <button type="submit" class="btn btn-sm btn-warning js_buy_ticket" <?php if($num_one == 0): ?>disabled="disabled"<?php endif; ?>><i class="fa fa-cart-plus"></i><span <?php if($num_one == 0): ?>class="gray-font"<?php endif; ?>>订票</span></button><!-- 若无票 按钮增加class选择符:gray-font -->
        </div>
        </form>
      </li>
      <li class="flex-item">
        <div class="ticket-chip">
          <span class="price">&yen;<?php echo $price_content[1]['price'];?></span>
        </div>
        <div class="ticket-chip">
         <?php echo $price_content[1]['title'];?>排
        </div>
        <div class="ticket-chip">
            <?php $num_two = $price_content[1]['num']-get_type_piao($data['id'],2); ?>
          <span <?php if($num_two == 0): ?>class="gray-font"<?php endif; ?>>余票:<span class="js_remainder"><?php echo $num_two;?></span></span>
        </div>
        <form class="js_book_ticket_form" action="<?php echo U('Wap/Booking/order');?>" method="post">
        <div class="ticket-chip">
          <div class="ticket-buy-num" data-count="<?php echo $num_two;?>">
            <i class="fa fa-minus js_minus_num"></i>
            <input type="text" name="num" value="1" />
            <!--票数X数量，计算价格-->
            <input type="hidden" name="price" value="<?php echo $price_content[1]['price'];?>">
            <input type="hidden" name="type_id" value="2">
            <input type="hidden" name="id" value="<?php echo $data['id'];?>">
            <i class="fa fa-plus js_plus_num"></i>
          </div>
        </div>
        <div class="ticket-chip">
          <button type="submit" class="btn btn-sm btn-warning js_buy_ticket" <?php if($num_two == 0): ?>disabled="disabled"<?php endif; ?>><i class="fa fa-cart-plus"></i><span <?php if($num_two == 0): ?>class="gray-font"<?php endif; ?>>订票</span></button>
        </div>
        </form>
      </li>
      <li class="flex-item">
        <div class="ticket-chip">
          <span class="price">&yen;<?php echo $price_content[2]['price'];?></span>
        </div>
        <div class="ticket-chip">
          <?php echo $price_content[2]['title'];?>排
        </div>
        <form class="js_book_ticket_form" action="<?php echo U('Wap/Booking/order');?>" method="post">
        <div class="ticket-chip">
          <?php $num_san = $price_content[2]['num']-get_type_piao($data['id'],3); ?>
          <span <?php if($num_san == 0): ?>class="gray-font"<?php endif; ?>>余票:<span class="js_remainder"><?php echo $num_san;?></span></span>
        </div>
        <div class="ticket-chip">
          <div class="ticket-buy-num" data-count="<?php echo $num_san;?>">
            <i class="fa fa-minus js_minus_num"></i>
            <input type="text" name="num" value="1" />
            <!--票数X数量，计算价格-->
            <input type="hidden" name="price" value="<?php echo $price_content[2]['price'];?>">
            <input type="hidden" name="type_id" value="3">
            <input type="hidden" name="id" value="<?php echo $data['id'];?>">
            <i class="fa fa-plus js_plus_num"></i>
          </div>
        </div>
        <div class="ticket-chip">
          <button type="submit" class="btn btn-sm btn-warning js_buy_ticket" <?php if($num_san == 0): ?>disabled="disabled"<?php endif; ?>><i class="fa fa-cart-plus"></i><span <?php if($num_san == 0): ?>class="gray-font"<?php endif; ?>>订票</span></button>
        </div>
        </form>
      </li>
    </ul>
    <div class="notice">
      <div class="title">订票说明</div>
      <div class="notice-say">
      <!--微信订票暂不收取票款，后台系统将自动为您预定座位，请您至少提前30分钟至现场凭兑票SN码及相应票款兑换演出门票。
      演出开演前30分钟，未兑换演出门票的座位预定，系统将自动释放以另行销售-->
      <?php echo $data['remark'];?>
      </div>
    </div>
  </div>
  <!-- 预定成功modal -->
  <div class="modal fade" id="bookTicketOk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">预订成功</h4>
        </div>
        <div class="modal-body ticket-book-ok">
          <h3>您已预订成功，谢谢！</h3>
          <p>兑票SN码：<span class="js_sncode">QJY395662295</span> </p><!--返回sn-->
          <div class="tips">
            <!--请于演出开始前至少30分钟至现场凭兑票SN码及相应票款兑换演出门票。-->
            <?php echo $data['rule'];?>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">好的</button>
        </div>
      </div>
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