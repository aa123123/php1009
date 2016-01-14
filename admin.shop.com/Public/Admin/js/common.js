$(function(){
    //实现全部选复选框选中
     $('.selectAll').click(function(){
         $('.ids').prop('checked',$(this).prop('checked'));
     });

    $('.ids').click(function(){
        $('.selectAll').prop('checked',$('.ids:not(:checked)').length==0);
    });




  //通用的ajax的请求
  $('.ajax-get').click(function(){
    //发送agax请求
    var url =$(this).attr('href');
    $.get(url,showAjaxLayer);
    return false;
  });

 //完成通用的ajax-post请求
  $('.ajax-post').click(function(){
       //发送post请求
      //找到form上的url地址
    var form = $(this).closest('form');
      if(form.length!=0){
          form.ajaxSubmit({ success:showAjaxLayer});
      }else{
          var url = $(this).attr('url');//删除按钮自定义URL地址
          var params = $('.ids:checked').serialize();
          $.post(url,params,showAjaxLayer);
      }
    //var url = form.attr('action');
    //var params =  form.serialize();
    //$.post(url,params,showAjaxLayer);

       return false;
  });

   //显示一个提示框
    function showAjaxLayer (data){
       var icon;
        if(data.status){
          icon = 1;
        }else{
          icon = 2;
        }
        layer.msg(data.info, {
          time:1000,
          offset: 0,
          shift: 2,
          icon:icon
        },function(){
          location.href=data.url;
        });
    }


});