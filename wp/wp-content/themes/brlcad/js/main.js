// sticky footer
jQuery(document).ready(function ($) {
  var bodyHeight = $("#content").outerHeight() + $("#site-footer").outerHeight();
  var vwptHeight = $(window).height();
  // if window height > body height, apply absolute position to footer
  if (vwptHeight > bodyHeight) {
	var styles = {
      position : "absolute",
      bottom: 0,
      left: 0,
      right: 0
    };
    $("footer#site-footer").css(styles);
  }
});

// equal height
jQuery(document).ready(function ($) {

  equalheight = function(container){

  var currentTallest = 0,
       currentRowStart = 0,
       rowDivs = new Array(),
       $el,
       topPosition = 0;
   $(container).each(function() {

     $el = $(this);
     $($el).height('auto')
     topPostion = $el.position().top;

     if (currentRowStart != topPostion) {
       for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
         rowDivs[currentDiv].height(currentTallest);
       }
       rowDivs.length = 0; // empty the array
       currentRowStart = topPostion;
       currentTallest = $el.height();
       rowDivs.push($el);
     } else {
       rowDivs.push($el);
       currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
    }
     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
   });
  }

  $(window).load(function() {
    equalheight('.equalize');
  });

  $(window).resize(function(){
    equalheight('.equalize');
  });

});

// documentation menu dropdown effect
jQuery(document).ready(function ($) {

  $('aside.menu').fadeIn(200);

  $('aside.menu li.current_page_item').parent().css({display:'inline-block'}).parent().addClass('active');

  $('aside.menu li.menu-item-has-children a').on("click", function(){
    var that = $(this).parent();
    if($('.sub-menu',that).is(':visible')){ /* is shown */
      $('.sub-menu',that).css({display:'none'});
      $(that).removeClass('active');
    }else{ /* not shown */
      $('.sub-menu',that).fadeIn(200);
      $(that).siblings('li').not(that).find('.sub-menu').css({display: 'none'}).parent().removeClass('active');
      $(that).addClass('active');
    }
  });
});

// responsive nav 
jQuery(document).ready(function ($) {

  $('div.menu-toggle').on("click", function(){
    $('nav#site-navigation').toggle();
  });

});