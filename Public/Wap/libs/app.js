$(function(){
  //图片懒加载
  $("img.lazy").lazyload();

  //通用横排一个slider
  var mySwiper = new Swiper ('.video-slider', {
     loop: true,
     // 如果需要分页器
     pagination: '.swiper-pagination',
     onInit: function(swiper){
         swiper.container[0].style.height=swiper.slides[swiper.activeIndex].offsetHeight+'px';
     },
     onSlideChangeEnd: function(swiper){
         swiper.container[0].style.height=swiper.slides[swiper.activeIndex].offsetHeight+'px';
     }
   });

  //bbs内容页显示音频视频 
  $(document).on('click','.js_toggle_btn',function(){
    var showEle=$(this).attr('data-show');
    $('.player-box').addClass('hide');
    $('.'+showEle).removeClass('hide');
    if(showEle=='bbs-video-play'){
      document.getElementById('bbs-audio').pause();
      console.log(1)
    }else{
      document.getElementById('bbs-video').pause();
      console.log(2)
    }
  });

  //手机号码拨号
  $('.js_call_number').on('input propertychange',function(){
    var val=$(this).val();
    $('.call-btn').attr('href','tel:'+val);
  });

   //无票提示
   $(document).on('click','.js_not_ticket',function(event){
    event.preventDefault();
    layer.alert('您选择的场次票已售罄！');
   });

   //页面进入后初始化剩余票（其实就是后端的-1，因为输入框有1）
   $('.js_remainder').each(function(){
    var showCount=Number($(this).text());
    $(this).text(showCount-1)
   });  

   //订票输入数量处理
   $('.ticket-buy-num input[name="num"]').on('input propertychange',function(){
    var $this=$(this);
    var totalCount=Number($this.parents('.ticket-buy-num').attr('data-count'));
    var ticketCount=Number($this.val());
    if(ticketCount<1 && ticketCount!=''){
      $this.val(1);
      layer.msg('购买数量不能少于1张');
    }else if(ticketCount=='' || ticketCount==0){
      $this.val(1);
      layer.msg('至少要购买一张');
    }else if(ticketCount>totalCount){
      layer.msg('购买数量超出剩余票量');
      $this.val(totalCount);
    }
    $(this).parents('.flex-item').find('.js_remainder').text(totalCount-ticketCount);
   }); 
   //购买票数+-
   $(document).on('click','.ticket-buy-num .fa',function(){
    var ticketCount=Number($(this).parents('.ticket-buy-num').attr('data-count'));
    var countInput=$(this).parents('.ticket-buy-num').find('input[name="num"]');
    var nowTicketCount=Number(countInput.val());
    if($(this).hasClass('js_minus_num')){
      nowTicketCount-=1;
      if(nowTicketCount<1){
        nowTicketCount=1;
        countInput.val(nowTicketCount);
      }else{
        countInput.val(nowTicketCount);
      }
    }else if($(this).hasClass('js_plus_num')){
      nowTicketCount+=1;
      if(nowTicketCount>ticketCount){
        nowTicketCount=ticketCount;
      }
      countInput.val(nowTicketCount);
    }
    $(this).parents('.flex-item').find('.js_remainder').text(ticketCount-nowTicketCount);
   });

   //买票
   $(document).on('submit','.js_book_ticket_form',function(event){
    event.preventDefault();
    var $this=$(this);
    var url=$this.attr('action');
    $.ajax({
      type:'POST',
      url:url,
      data:$this.serialize(),
      dataType:'json',
      success:function(d){
        if(d.s==0){
          var sncode=d.sn;
          $('#bookTicketOk').find('.js_sncode').text(sncode);
          $('#bookTicketOk').modal();
          layer.msg(d.msg);
          setTimeout(function(){
            window.location.href='http://'+location.host+'/index.php/wap/member/index.html';
          },200)
        }else if(d.s==3){
          layer.msg(d.msg);
          setTimeout(function(){
            window.location.href='http://'+location.host+d.url;
          },200);
        }else{
          layer.msg(d.msg);
        }
      }
    });
   });

  //会员中心领取优惠券
  $(document).on('click','.js_get_coupon',function(){
    var $this=$(this);
    var _id=$this.attr('data-id');
    var _url=$this.attr('data-url');
    $.ajax({
      type:'POST',
      url:_url,
      data:{"id":_id},
      dataType:'json',
      success:function(d){
        if(d.s==0){
            layer.msg(d.msg);
           $this.before('<p>已领取</p>');
           $this.parents('.js_get_coupon_box').append('<p class="base-color">SN码：'+d.sn+'</p>');
           $this.remove();
        }else if(d.s==3){
          layer.msg(d.msg);
          setTimeout(function(){
            window.location.href='http://'+location.host+d.url;
          },200);
        }else{
          layer.msg(d.msg);
        }
      }
    });
  });

   //图片上传，多个
   ;(function(){
    $('.js_upload_control').each(function(index){
      var picUploadUrl=$(this).attr('data-url');
      $(this).attr('id','js_upload_control'+index);
       var picUploader = new plupload.Uploader({
         browse_button : 'js_upload_control'+index, //触发文件选择对话框的按钮，为那个元素id
         url : picUploadUrl, //服务器端的上传页面地址
         flash_swf_url : 'js/Moxie.swf', //swf文件，当需要使用swf方式进行上传时需要配置该参数
         file_data_name:'pic',
         filters: {
           mime_types : [ //只允许上传图片
             { title : "图片类型", extensions : "jpg,gif,png,bmp,jpeg"}
           ]
         },
         silverlight_xap_url : 'js/Moxie.xap' //silverlight文件，当需要使用silverlight方式进行上传时需要配置该参数
       });
       var uploadContent=$(this).attr('data-upload');

       picUploader.bind('FilesAdded',function(uploader,files){
           //每个事件监听函数都会传入一些很有用的参数，
           //我们可以利用这些参数提供的信息来做比如更新UI，提示上传进度等操作
      $('.'+uploadContent).append('<li class="upload-control js_upload_item '+files[0].id+'" data-id="'+files[0].id+'"><div class="has-upload js_upload_pic_item"><img src="" alt="" /><i class="state fa fa-spinner fa-spin"></i></div><div class="pic-del-box js_del_this_pic"><i class="fa fa-trash-o"></i></div></li>');
          
          
          picUploader.start();
           
       });
       picUploader.bind('UploadProgress',function(uploader,files){
           //每个事件监听函数都会传入一些很有用的参数，
           //我们可以利用这些参数提供的信息来做比如更新UI，提示上传进度等操作
       });
       picUploader.bind('FileUploaded',function(uploader,file,responseObject){ 
        var data=JSON.parse(responseObject.response);
          $('.'+file.id).find('.has-upload').find('img').attr({'src':data.url,'alt':data.name});
          $('.'+file.id).find('.has-upload').find('.state').hide();
       });

       picUploader.bind('Error',function(uploader,errObject){ 
        layer.msg('上传错误,错误信息:'+errObject.message);
       });
         //在实例对象上调用init()方法进行初始化
        picUploader.init();
      });

      //删除图片
      $(document).on('click','.js_del_this_pic',function(){
        var $this=$(this);
        $(this).css('opacity',1);
        layer.confirm('确定删除这张图片吗?', {
            btn: ['确定','取消'] //按钮
        }, function(){
          $this.parents('.js_upload_item').remove();
          layer.msg('已删除');
        }, function(){
          $this.css('opacity',0);
        });
      });
    })();

    //视频音频，单个上传（限制了单个）
    ;(function(){
     $('.js_upload_player').each(function(index){
      var uploadType=$(this).attr('data-type');
      var uploadContent=$(this).attr('data-upload');
      var picUploadUrl=$(this).attr('data-url');
      var fileName='';
      var exten="";
      if(uploadType=='video'){
        fileName='video';
        exten="mp4,mpg,ogg,mpeg";
      }else if(uploadType=='audio'){
        fileName='audio';
        exten="mp3,amr,MP3,aiff,avi";
      }
      $(this).attr('id','js_upload_player'+index);
      var picUploader = new plupload.Uploader({
        browse_button : 'js_upload_player'+index, //触发文件选择对话框的按钮，为那个元素id
        url : picUploadUrl, //服务器端的上传页面地址
        flash_swf_url : 'js/Moxie.swf', //swf文件，当需要使用swf方式进行上传时需要配置该参数
        file_data_name:fileName,
        multi_selection: false,
       filters: {
         mime_types : [ //只允许上传图片和zip文件
           { title : "音频视频文件", extensions : exten }
         ]
       },
        silverlight_xap_url : 'js/Moxie.xap' //silverlight文件，当需要使用silverlight方式进行上传时需要配置该参数
      });

        picUploader.bind('FilesAdded',function(uploader,files){
            //每个事件监听函数都会传入一些很有用的参数，
            //我们可以利用这些参数提供的信息来做比如更新UI，提示上传进度等操作
            var uploadCount=$('.'+uploadContent).attr('data-count');
            console.log(uploadCount);
              if (uploadCount<1 || uploadCount==undefined) {
                 if(uploadType=='video'){
                  $('.'+uploadContent).attr('data-count',1)
                  $('.'+uploadContent).append('<div class="js_upload_item player-upload js_video_upload_item" id="'+files[0].id+'" data-url="" data-id="'+files[0].id+'"><div class="has-upload"><i class="fa fa-video-camera"></i> <span></span><i class="state fa fa-spinner fa-spin"></i></div><div class="stop-upload"></div><div class="player-del js_del_this_player" data-del="'+uploadContent+'"><i class="fa fa-trash-o"></i></div></div>');
                }else if(uploadType=='audio'){
                  $('.'+uploadContent).append('<div class="js_upload_item player-upload js_audio_upload_item" id="'+files[0].id+'" data-url="" data-id="'+files[0].id+'"><div class="has-upload"><i class="fa fa-tripadvisor"></i> <span></span><i class="state fa fa-spinner fa-spin"></i></div><div class="stop-upload"></div><div class="player-del js_del_this_player" data-del="'+uploadContent+'"><i class="fa fa-trash-o"></i></div></div>');
                }
                
                picUploader.start();
                return;
              }else{
                 uploader.splice(1, 1)
                layer.msg('抱歉，这里只允许上传一个文件');
              }

             //uploader.removeFile(file);
            
            
        });
        picUploader.bind('UploadProgress',function(uploader,files){
            //每个事件监听函数都会传入一些很有用的参数，
            //我们可以利用这些参数提供的信息来做比如更新UI，提示上传进度等操作
        });
        picUploader.bind('FileUploaded',function(uploader,file,responseObject){
         var data=JSON.parse(responseObject.response);
           console.log(file.name);
           $('#'+file.id).find('.has-upload').find('span').text(file.name);
           $('#'+file.id).attr('data-url',data.url);
           $('#'+file.id).find('.has-upload').find('.state').hide();
           $('#'+file.id).find('.stop-upload').hide();
           if(uploadType=='video'){
            $('[name="video_url"]').val(data.url);
           }else if(uploadType=='audio'){
            $('[name="audio_url"]').val(data.url);
           }

        });

        picUploader.bind('Error',function(uploader,errObject){ 
          if(errObject.message='File extension error.'){
            layer.msg('不支持的格式');
          }else{
            layer.msg('上传错误,错误信息:'+errObject.message);
          }
        });
          //在实例对象上调用init()方法进行初始化
         picUploader.init();
         //删除图片
         $(document).on('click','.js_del_this_player',function(){
           var $this=$(this);
           layer.confirm('确定删除吗?', {
               btn: ['确定','取消'] //按钮
           }, function(){
           $('.'+$this.attr('data-del')).attr('data-count',0);
            picUploader.splice(0, 1);
             $this.parents('.js_upload_item').remove();
             layer.msg('已删除');
           }, function(){
           });
         });
       });


     })();

     //上传头像
     ;(function(){
      if($('#js_upload_photo').length>0){
        var uploadUrl=$('#js_upload_photo').attr('data-url');
         var picUploader = new plupload.Uploader({
           browse_button : 'js_upload_photo', //触发文件选择对话框的按钮，为那个元素id
           url : uploadUrl, //服务器端的上传页面地址
           flash_swf_url : 'js/Moxie.swf', //swf文件，当需要使用swf方式进行上传时需要配置该参数
           file_data_name:'pic',
           filters: {
             mime_types : [ //只允许上传图片
              { title : "图片类型", extensions : "jpg,gif,png,bmp,jpeg"}
             ]
           },
           multi_selection: false,
           silverlight_xap_url : 'js/Moxie.xap' //silverlight文件，当需要使用silverlight方式进行上传时需要配置该参数
         });
         var uploadContent=$(this).attr('data-upload');

         picUploader.bind('FilesAdded',function(uploader,files){
             //每个事件监听函数都会传入一些很有用的参数，
             //我们可以利用这些参数提供的信息来做比如更新UI，提示上传进度等操作
          $('#js_upload_photo').find('.state').show();          
          picUploader.start();
             
         });
         picUploader.bind('UploadProgress',function(uploader,files){
             //每个事件监听函数都会传入一些很有用的参数，
             //我们可以利用这些参数提供的信息来做比如更新UI，提示上传进度等操作
         });
         picUploader.bind('FileUploaded',function(uploader,file,responseObject){ 
          var data=JSON.parse(responseObject.response);
            $('#js_upload_photo').find('img').attr({'src':data.url,'alt':data.name});
            $('[name="headerpic"]').val(data.url);
            $('#js_upload_photo').find('.state').hide();
         });

         picUploader.bind('Error',function(uploader,errObject){ 
          layer.msg('上传错误,错误信息:'+errObject.message);
         });
           //在实例对象上调用init()方法进行初始化
          picUploader.init();
      }
      
    })();






   //发表字段填写验证
   $(".js_post_bbs").validate({
    rules: {
      title: "required",
      content: {
        required: true,
        minlength: 3
      }
    },
    messages: {
      title: "标题不能为空",
      content: {
       required: "请输入内容",
       minlength: "能不能多说点？"
     }
    }
  });

   //发表bbs
   $(document).on('submit','.js_post_bbs',function(event){
    event.preventDefault();
    $form=$(this);
    //先收集图片
    var pics=[];
    $form.find('.js_upload_pic_item').each(function(index, el) {
      pics.push($(this).find('img').attr('src'));
    });
    //收集视频
    $form.find('[name="video_url"]').val($form.find('.js_video_upload_item').attr('data-url'));
    $form.find('[name="audio_url"]').val($form.find('.js_audio_upload_item').attr('data-url'));
    var picstr=pics.join(',');
    $form.find('[name="pic"]').val(picstr);
    console.log($form.find('[name="pic"]').val());
    if($(".js_post_bbs").valid){
      $.ajax({
      type:'POST',
      url:$form.attr('action'),
      data:$form.serialize(),
      dataType:'json',
      success:function(d){
        if(d.s==0){
          layer.msg(d.msg);
          setTimeout(function(){
            window.location.href='http://'+location.host+'/index.php/wap/member/bbs'
          },200);
        }else{
          layer.msg(d.msg);
        }
      }
    });
    }
    
   });

   //bbs点赞
   $(document).on('click','.js_thumb',function(event){
    event.preventDefault();
    var $this=$(this);
    var _id=$this.attr('data-id');
    var _url=$this.attr('href');
    $.ajax({
      type:'POST',
      url:_url,
      data:{"id":_id},
      dataType:'json',
      success:function(d){
        var nowUrl=_url;
        if(d.s==0){
          if($this.find('.fa').hasClass('fa-thumbs-o-up')){
            $this.find('.fa').removeClass('fa-thumbs-o-up').addClass('fa-thumbs-up');
            $this.find('.js_thumbs_num').text(d.zans);
            nowUrl=nowUrl.replace('zan','cancel_zan');
            $this.attr('href',nowUrl);
          }else{
            $this.find('.fa').removeClass('fa-thumbs-up').addClass('fa-thumbs-o-up');
            $this.find('.js_thumbs_num').text(d.zans);
            nowUrl=nowUrl.replace('cancel_zan','zan');
            $this.attr('href',nowUrl);
          }
        }else{
          layer.msg(d.msg);
        }
      }
    });
   });

   //bbs爱心收藏
   $(document).on('click','.js_like',function(event){
    event.preventDefault();
    var $this=$(this);
    var _id=$this.attr('data-id');
    var _url=$this.attr('href');
    $.ajax({
      type:'POST',
      url:_url,
      data:{"id":_id},
      dataType:'json',
      success:function(d){
        var nowUrl=_url;
        if(d.s==0){
          if($this.find('.fa').hasClass('fa-heart-o')){
            $this.find('.fa').removeClass('fa-heart-o').addClass('fa-heart');
            $this.find('.js_like_num').text(d.likes);
            nowUrl=nowUrl.replace('likes','cancel_likes');
            $this.attr('href',nowUrl);
          }else{
            $this.find('.fa').removeClass('fa-heart').addClass('fa-heart-o');
            $this.find('.js_like_num').text(d.likes);
            nowUrl=nowUrl.replace('cancel_likes','likes');
            $this.attr('href',nowUrl);
          }
        }else{
          layer.msg(d.msg);
        }
      }
    });
   });



   //tab 通用外层元素tab-wrap 切换控件tab-btn 切换区域tab-container
  $('.tab-wrap').each(function(index) {
    var $this=$(this);
    var $btn=$this.find('.tab-btn');
    var $tabBox=$this.find('.tab-container');
    //初始化,带cur的显示
    var curIndex=0;
    $btn.each(function(){
      if($(this).hasClass('cur')){
        curIndex=$(this).index();
      }
    });
    $btn.removeClass('cur').eq(curIndex).addClass('cur');
    $tabBox.hide().eq(curIndex).show();
    $btn.click(function(){
      curIndex=$(this).index();
      $btn.removeClass('cur').eq(curIndex).addClass('cur');
      $tabBox.hide().eq(curIndex).show();

    });
  });

  //video内容页评论
  $(document).on('submit','.js_comment_form',function(event){
    event.preventDefault();
    var $this=$(this);
    var url=$this.attr('action');
    if($this.find('[name="content"]').val()==''){
      layer.msg('评论内容不能为空');
      $this.find('[name="content"]').focus();
    }else{
      $.ajax({
        type:'POST',
        url:url,
        data:$this.serialize(),
        dataType:'json',
        success:function(d){
          if(d.s==0){
            $this.find('[name="content"]').val('');
            layer.msg(d.msg);
            //拼接出评论展示
            var thisComment='<div class="comment-item">'+
                            '<div class="u-img">'+
                              '<img src="'+d.img+'">'+
                            '</div>'+
                            '<div class="comment-info">'+
                              '<div class="comment-body">'+
                                '<div class="comment-author clearfix">'+
                                  '<div class="u-name fl">'+d.name+'</div>'+
                                  '<div class="dates fr">'+d.date+'</div>'+
                                '</div>'+
                                '<div class="comment-say">'+d.content+'</div>'+
                              '</div>'+
                            '</div>'+
                          '</div>';
            $('.comments').prepend(thisComment);
          }else if(d.s==2){
            //layer.msg(d.msg);
            setTimeout(function(){$('#userReg').modal();},200)
          }else{
            layer.msg(d.msg);
          }
        }
      });
    }
    
  });

  //注册
  $(document).on('submit','.js_reg_form',function(event){
    event.preventDefault();
    var $this=$(this);
    var url=$this.attr('action');
    $.ajax({
      type:'POST',
      url:url,
      data:$this.serialize(),
      dataType:'json',
      success:function(d){
        if(d.s==0){
          layer.msg(d.msg);
          $('#userReg').modal('hide');
        }else{
          layer.msg(d.msg);
        }
      }
    });
  });

  $(document).on('click','.js_choose_this_photo',function(event){
    event.preventDefault();
    $('.js_choose_this_photo').removeClass('cur');
    $(this).addClass('cur');
    var imgUrl=$(this).find('img').attr('src');
    $('.js_my_photo').attr('src',imgUrl);
    $('[name="headerpic"]').val(imgUrl);
  });

  //用户设置头像+手机绑定
  $(document).on('submit','.js_set_user',function(event){
    event.preventDefault();
    var $form=$(this);
    $.ajax({
      type:'POST',
      url:$form.attr('action'),
      data:$form.serialize(),
      dataType:'json',
      success:function(d){
        if(d.s==0){
          layer.msg(d.msg);
        }else{
          layer.msg(d.msg);
        }
      }
    });
  });

  //bbs列表页多个slider
 /* $('.bbs-photo-wrap').each(function(){
    //$(this)
  });*/
      var swiper = new Swiper('.bbs-photo-wrap', {
        wrapperClass : 'bbs-photo-list',
        slideClass : 'bbs-photo-item',
        slidesPerView: 'auto',
        paginationClickable: true
    });

});