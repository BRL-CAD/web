        <!-- Footer Starts here -->
        <footer>
        <p class="wrapped footer-text quote">"A professional is a person who can do his best at a time when he doesn't particularly feel like it." - Alistair Cooke</p>

<p class="wrapped footer-text">All trademarks referenced herein are the properties of their respective owners. This site is not sponsored, endorsed, or run by the U.S. Government.</p>
        </footer>
	</div> <!-- container ends here -->
	    
    <!--\\\\\\THE SCRIPT DUNGEON//////////-->
    
    <!-- loading jquery,tinynav plugin and slider plugin -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="wp-content/themes/BRL-CAD/scripts/tinynav.min.js"></script>
    <!-- script for the toggle menu -->
    <script>
    var isOpen = true;
    $("#logo").click(function(){
        var headHeight = $(".head").height();

        if(isOpen)
        {
            $(".head").animate({
                "top":"-"+headHeight
            }, 1000 );
            isOpen=false;
        }
        else
        {
            $(".head").animate({
                "top":"0px"
            }, 1000);
            isOpen=true;
        }
    });
    </script>
    <!-- script to convert navigation into select box on mobile -->
    <script>
        $(function () {
            $('#main-nav').tinyNav();
        });
    </script>
    <!-- script to initiate scroll on same anchor, credits:css-tricks.com -->
    <script>
    $(function() {
  $('a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
       
});
        </script>
</body>
</html>
 <!-- Cheers! -->