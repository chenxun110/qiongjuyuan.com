<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>微信管理平台</title>
<link href="/Public/User/css/bootstrap.css" rel="stylesheet" />
<link href="/Public/User/css/font-awesome.css" rel="stylesheet" />
<link href="/Public/User/css/admin.css" rel="stylesheet" />
<script src="/Public/User/js/jquery.js"></script>
<script src="/Public/User/js/bootstrap.min.js"></script>
</head>
<body>
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
    height: 332px;
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
    min-width: 224px;
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
 <div class="span12"><input onclick="checkAll(this)" type="checkbox">全选 &nbsp;&nbsp;&nbsp;&nbsp;<span class="btn btn-success" onclick="select()">确定</span><?php echo ($page); ?></div>
 <hr/>
<div class="span12 main">
<?php if(is_array($list)): foreach($list as $key=>$list): ?><div class="span3">
    <div class="appmsg ">
         <div class="appmsg_content">
        
            <h4 class="appmsg_title"><input type="checkbox" name="checkbox" value="<?php echo ($list['id']); ?>"><?php echo msubstr($list['title'],0,10,'utf-8',true);?></h4>
            <div class="appmsg_info"><em class="appmsg_date"><?php echo (date('m月d日',$list['addtime'])); ?></em></div>
            <div class="appmsg_thumb_wrp">
              <img class="appmsg_thumb" alt="" src="<?php echo ($list['picurl']); ?>"></div>
            <p class="appmsg_desc"><?php echo msubstr($list['description'],0,30,'utf-8',false);?></p>
        
    </div>
  </div>
   </div><?php endforeach; endif; ?>
</div>
<script>
  //全选   
  function checkAll(o){
        if( o.checked == true ){
            $('input[name="checkbox"]').attr('checked','true');
            
        }else{
            $('input[name="checkbox"]').removeAttr('checked');
           
        }
    }  
    
  //获取已选择的ID数组
    function getChecked() {
        var ids = new Array();
        $.each($('.main input:checked'), function(i, n){
            if($(n).val()!=0)
            {
                ids.push( $(n).val() );
            }
            
        });
        return ids;
    }    	
	 function select(ids) {
        var length = 0;
       
        if(ids) {
            length = 1;
        }else {
            ids    = getChecked();
            length = ids[0] == 0 ? ids.length - 1 : ids.length;
            ids    = ids.toString();
        }
        if(ids=='') {
            alert('请先选择要的图文');
            return false;
        }
        if(confirm('您将选择'+length+'条图文,确定继续？')) {
            $.post("<?php echo U(GROUP_NAME.'/Muti/selectids');?>",{ids:ids},function(data){
               if(data.status==1) {
                     $('.news', window.parent.document).html(data.msg);
                      window.parent.$('#newslist').modal('hide');
                }else {
                   alert('操作失败');
                   return false
                }
            },'json');
        }
    }
</script>
</body>
</html>