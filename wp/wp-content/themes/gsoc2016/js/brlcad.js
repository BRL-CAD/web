$(document).ready(function(){
    //Enable slide-out menu
    $(".button-collapse").sideNav();

    //Init select
    $(document).ready(function() {
      $('select').material_select();
    });
    
    //Mailing list
     $("form#mail-subscribe").submit(function() {
     var surl =  "https://lists.sourceforge.net/lists/subscribe/"+ $("li.active.selected>span").text() + '?' + $(this).serialize();
     $.ajax({
  		url: surl,
  		dataType: "jsonp",
  		jsonpCallback: function(){  $('.message-mail').css("display","block"); }
  		});
      return false;
   });
});
