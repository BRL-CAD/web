$(document).ready(function() {
  //Enable slide-out menu
  $(".button-collapse").sideNav({
    edge: 'right', // Choose the horizontal origin
  });

  //Init select
  $(document).ready(function() {
    $('select').material_select();
  });

  //Mailing list
  $("form#mail-subscribe").submit(function() {
    var list_id = "brlcad-news";
    switch ($("li.active.selected>span").text()) {
      case "News":
        list_id = "brlcad-news";
        break;
      case "Users":
        list_id = "brlcad-users";
        break;
      case "Development":
        list_id = "brlcad-devel";
        break;
    }
    var surl = "https://lists.sourceforge.net/lists/subscribe/" + list_id + '?' + $(this).serialize();
    $.ajax({
      url: surl,
      dataType: "jsonp",
      jsonpCallback: function() {
        $('.message-mail').css("display", "block");
      }
    });
    return false;
  });
});