$(function()
{
  $('.username').keyup(function()
  {
  var checkname=$(this).val();
 var availname=remove_whitespaces(checkname);
  if(availname!=''){
  $('.check').show();
  $('.check').fadeIn(400).html('<img src="img/load.gif" /> ');

  var String = 'login='+ availname;
  
  $.ajax({
          type: "POST",
          url: "test.php",
          data: String,
          cache: false,
          success: function(result){
               var result=remove_whitespaces(result);
               if(result==''){
                       $('.check').html('<img src="img/ok.png" /> Имя пользователя доступно для регистрации');
                       $(".check").removeClass("red");
					   $('.check').addClass("green");
                       $(".username").removeClass("yellow");
                       $(".username").addClass("white");
               }else{
                       $('.check').html('<img src="img/no.png" /> Пользователь с этим логином уже зарегистрирован! Используйте другой! <input required="true" type="checkbox" class="checkhide">');
                       $(".check").removeClass("green");
					   $('.check').addClass("red")
                       $(".username").removeClass("white");
                       $(".username").addClass("yellow");
               }
          }
      });
   }else{
       $('.check').html('');
   }
  });


});

function remove_whitespaces(str){
     var str=str.replace(/^\s+|\s+$/,'');
     return str;

}