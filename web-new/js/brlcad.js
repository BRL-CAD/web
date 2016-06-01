$(document).ready(function(){
    //Enable slide-out menu
    $(".button-collapse").sideNav();   
    
    //Mailing list
     $("form#mail-subscribe").submit(function() {
     var surl =  $(this).attr('action') + '?' + $(this).serialize();
     $.ajax({
  		url: surl,
  		dataType: "jsonp",
  		jsonpCallback: function(){  $('.message-mail').css("display","block"); }
  		});
      return false;
   });
});
