$(function(){
    //ʵ��ȫ��ѡ��ѡ��ѡ��
     $('.selectAll').click(function(){
         $('.ids').prop('checked',$(this).prop('checked'));
     });

    $('.ids').click(function(){
        $('.selectAll').prop('checked',$('.ids:not(:checked)').length==0);
    });




  //ͨ�õ�ajax������
  $('.ajax-get').click(function(){
    //����agax����
    var url =$(this).attr('href');
    $.get(url,showAjaxLayer);
    return false;
  });

 //���ͨ�õ�ajax-post����
  $('.ajax-post').click(function(){
       //����post����
      //�ҵ�form�ϵ�url��ַ
    var form = $(this).closest('form');
      if(form.length!=0){
          form.ajaxSubmit({ success:showAjaxLayer});
      }else{
          var url = $(this).attr('url');//ɾ����ť�Զ���URL��ַ
          var params = $('.ids:checked').serialize();
          $.post(url,params,showAjaxLayer);
      }
    //var url = form.attr('action');
    //var params =  form.serialize();
    //$.post(url,params,showAjaxLayer);

       return false;
  });

   //��ʾһ����ʾ��
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