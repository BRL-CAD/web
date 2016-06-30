<?php /* Template Name: Front page */ ?>

<?php get_header(); ?>
<!-- Section 1 | HEADER -->
<div class="section1">
    <div class="container">
        <div class="row ">
            <div class="col l4 m12 s12 center">
                <h1>BRL-CAD</h1>
                <h5>OPEN SOURCE SOLID MODELING</h5>
                <a class="btn green white-text waves-effect waves-light" href="<?php echo site_url();?>/download/"><i class="material-icons left">get_app</i>DOWNLOAD</a>
                <a class="btn white black-text waves-effect" href="<?php echo site_url();?>/about/">ABOUT</a>
            </div>
        </div>
    </div>
</div>

<!-- Section 2 | NEWS AND LINKS -->
<div class="section2">
    <div class="container">
        <div class="row">
            <div class="col m5 s12">
                <a href="<?php echo site_url();?>/news/">
                    <h5><i class="material-icons black-text">rss_feed</i>Latest news</h5>
                </a>
                <ul class="collection">
                    <?php
                            $args = array( 'numberposts' => '3' );
                            $recent_posts = wp_get_recent_posts( $args );
                            foreach( $recent_posts as $recent ){
                                echo '<li class="collection-item"><span class="secondary-content">'.mysql2date('j M Y', $recent["post_date"]).'</span>
                                      <a href="' . get_permalink($recent["ID"]) . '">' .   $recent["post_title"].'</a>
                                      <p>'.wp_trim_words($recent["post_content"],5,"...").'</p></li> ';
                            }
                        ?>
                </ul>
            </div>
            <div class="col m6 push-m1 s12">
                <h5><i class="material-icons">link</i>Useful links</h5>
                <div class="row">
                    <div class="col s12 m5">
                        <ul class="useful-links">
                            <li><a href="http://brlcad.org/wiki/Overview">Getting started</a></li>
                            <li><a href="http://brlcad.org/wiki/FAQ">FAQ</a></li>
                            <li><a href="https://github.com/BRL-CAD">GitHub</a></li>
                            <li><a href="https://sourceforge.net/projects/brlcad/">SourceForge</a></li>
                            <li><a href="https://sourceforge.net/projects/brlcad/support">Support</a></li>
                        </ul>
                    </div>
                    <div class="col s12 m5 push-m1">
                        <ul class=" useful-links">
                            <li><a href="#">Online Geometry Viewer</a></li>
                            <li><a href="#">BRL-CAD Gallery</a></li>
                            <li><a href="#">Model Repository</a></li>
                            <li><a href="#">Google Summer of Code</a></li>
                            <li><a href="#">Googe Code-In</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section 3 | ABOUT-->
<div class="section3">
    <div class="container">
        <div class="row">
            <div class="col s12 m8 offset-m2">
                <div class="row promo-wrapper">
                    <div class="col s12 m12 l3 promo-image"><img src="<?php bloginfo('template_url');?>/img/promo1.png" alt=""></div>
                    <div class="col s10 offset-s1 m10 offset-m1 l7 offset-l2">
                        <h4 class="white-text">OPEN SOURCE</h4>
                        <p class="grey-text text-lighten-4">100% FREE with people all over the world contributing their thoughts. Escape vendor lock-in, for any purpose, forever.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row darker">
        <div class="container">
            <div class="col s12 m8 offset-m2">
                <div class="row promo-wrapper">
                    <div class="col s12 m12 l3 promo-image right"><img src="<?php bloginfo('template_url');?>/img/promo2.png" alt=""></div>
                    <div class="col s10 offset-s1 m10 offset-m1 l7">
                        <h4 class="white-text">JOIN US</h4>
                        <p class="grey-text text-lighten-4">Help make a better CAD system, make modeling fun. No experience necessary. </p>
                        <a href="<?php echo site_url();?>/get-involved/" class="btn-flat white-text waves-effect waves-light">GET INVOLVED</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col s12 m8 offset-m2">
                <div class="row promo-wrapper">
                    <div class="col s12 m12 l3 promo-image"><img src="<?php bloginfo('template_url');?>/img/promo3.png" alt=""></div>
                    <div class="col s10 offset-s1 m10 offset-m1 l7 offset-l2">
                        <h4 class="white-text">SOLID MODELING</h4>
                        <p class="grey-text text-lighten-4">Hybrid CSG and B-REP kernel with innovative methods for unambiguous 3D geometry. Verification, validation, performant.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section 4 | HIGHLIGHTS -->
<div class="section4">
    <div class="container">
        <h4>Highlights</h4>
        <div class="row">
            <div class="card">
                <div class="card-image waves-effect waves-block waves-light">
                    <img class="activator" src="<?php bloginfo('template_url');?>/img/Archer_logo.png">
                </div>
                <div class="card-content">
                    <span class="card-title activator grey-text text-darken-4">Cross platform<i class="material-icons right">more_vert</i></span>
                </div>
                <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4">Cross platform<i class="material-icons right">close</i></span>
                    <p>The package is intentionally designed to be extensively cross-platform and is actively developed on and maintained for many common operating system environments including for BSD, Linux, Solaris, Mac OS X, and Windows among others.
                        BRL-CAD is distributed in binary and source code form.</p>
                </div>
            </div>
            <div class="card">
                <div class="card-image waves-effect waves-block waves-light">
                    <img class="activator" src="<?php bloginfo('template_url');?>/img/Mike_Muuss.jpg">
                </div>
                <div class="card-content">
                    <span class="card-title activator grey-text text-darken-4">Since 1979<i class="material-icons right">more_vert</i></span>
                </div>
                <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4">Since 1979<i class="material-icons right">close</i></span>
                    <p>Mike Muuss began the initial architecture and design of BRL-CAD back in 1979. Development as a unified package began in 1983. The first public release was made in 1984. BRL-CAD became an open source project on 21 December 2004.</p>
                </div>
            </div>
            <div class="card">
                <div class="card-image waves-effect waves-block waves-light">
                    <img class="activator" src="<?php bloginfo('template_url');?>/img/documenting_redux.jpg">
                </div>
                <div class="card-content">
                    <span class="card-title activator grey-text text-darken-4">Trusted by U.S Military<i class="material-icons right">more_vert</i></span>
                </div>
                <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4">Trusted by U.S Military<i class="material-icons right">close</i></span>
                    <p>BRL-CAD is choice of U.S Military. For more than 20 years, BRL-CAD has been the primary tri-service solid modeling CAD system used by the U.S. military to model weapons systems for vulnerability and lethality analyses.</p>
                </div>
            </div>
            <div class="card">
                <div class="card-image waves-effect waves-block waves-light">
                    <img class="activator" src="<?php bloginfo('template_url');?>/img/mascot.png">
                </div>
                <div class="card-content">
                    <span class="card-title activator grey-text text-darken-4">Free & Open<i class="material-icons right">more_vert</i></span>
                </div>
                <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4">Free & Open<i class="material-icons right">close</i></span>
                    <p>BRL-CAD respects your freedom so our code is open source under OSI approved license terms, which means you can customize it according to your needs.It also means that you will get this software Free of cost and we won't charge you
                        ever for any update or support.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section 5 | MAILING LIST -->
<div class="section5">
    <div class="container center-align">
        <h4 class="white-text">Join our mailing list</h4>
        <div class="row" style="margin-bottom: 0px;">
            <form class="col m6 offset-m3 s12" action="https://lists.sourceforge.net/lists/subscribe/brlcad-news" id="mail-subscribe">
                <span class="message-mail white-text">Subscribed successfully</span>
                <div class="row left-align">
                    <div class="input-field col s12 ">
                        <input name="email" class="white-text" id="email" type="email" class="validate" required>
                        <label for="email" data-error="wrong" data-success="right">Email</label>
                    </div>
                </div>
                <input class="btn white black-text waves-effect" type="submit" value="Subscribe" />
            </form>
        </div>

    </div>
</div>


<?php get_footer(); ?>