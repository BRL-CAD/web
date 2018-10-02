<?php /* Template Name: Front page */ ?>

<?php get_header(); ?>
<!-- Banner -->
<div id="banner">
    <canvas id="tessellactation"></canvas>
    <div class="container">
        <div class="row" id="banner-screenshot">
            <div class="col l6 push-l6 s12 center">
                <img src="<?php bloginfo('template_url');?>/img/archer_screenshot.png"></img>
            </div>
            <div class="col l6 pull-l6 s12 center" id="banner-title">
                <div id="banner-title-content">
                    <h1>BRL-CAD</h1>
                    <h5>Think • Invent • Create</h5>
                    <a class="btn green white-text waves-effect waves-light" href="<?php echo site_url();?>/download/"><i class="material-icons left">get_app</i>DOWNLOAD 7.26.0</a>
                    <a class="btn white black-text waves-effect" href="<?php echo site_url();?>/news/release-7-26-0/">Release notes</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Introduction -->
<div id="introduction">
    <div class="container">
        <div class="row" id="introduction-about">
            <div class="col s12 m6" style="margin-bottom: 20px;">
                <h5>Open source solid modelling</h5>
                BRL-CAD is a powerful open source cross-platform solid modeling system that includes interactive geometry editing, high-performance ray-tracing for rendering and geometric analysis, a system performance analysis benchmark suite, geometry
                libraries for application developers, and more than 30 years of active development.
            </div>
            <div class="col s12 m6">
                <a href="<?php echo site_url();?>/news/">
                    <h5><i class="material-icons black-text" style="float: left;margin-right: 5px;">rss_feed</i>Latest news</h5>
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
        </div>
        <div class="row center" id="introduction-promo">
            <div class="col m4 s12">
                <img src="<?php bloginfo('template_url');?>/img/promo1.png" alt="">
                <h4>Open source</h4>
                <p>100% FREE with people all over the world contributing their thoughts. Escape vendor lock-in, for any purpose, forever.</p>
            </div>
            <div class="col m4 s12">
                <img src="<?php bloginfo('template_url');?>/img/promo2.png" alt="">
                <h4>Join us</h4>
                <p>Help make a better CAD system, make modeling fun. No experience necessary. </p>
                <a class="btn pink white-text waves-effect" href="<?php echo site_url();?>/get-involved/">GET INVOLVED</a>
            </div>
            <div class="col m4 s12">
                <img src="<?php bloginfo('template_url');?>/img/promo3.png" alt="">
                <h4>Solid modeling</h4>
                <p>Hybrid CSG and B-REP kernel with innovative methods for unambiguous 3D geometry. Verification, validation, performant.</p>
            </div>
        </div>
    </div>
</div>

<!-- Highlights -->
<div id="highlights">
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

<!-- Mailing list -->
<div id="mail">
    <div class="container center-align">
        <h4 class="white-text">Join our mailing list</h4>
        <div class="row" style="margin-bottom: 0px;">
            <form class="col m6 offset-m3 s12" action="" id="mail-subscribe">
                <span class="message-mail white-text">Check your email to confirm subscription</span>
                <div class="row left-align">
                    <div class="input-field col s4">
                        <select>
                        <option>News</option>
                        <option>Users</option>
                        <option>Development</option>
                        </select>
                    </div>
                    <div class="input-field col s8">
                        <input name="email" class="white-text" id="email" type="email" class="validate" required>
                        <label for="email" data-error="wrong" data-success="right">Email</label>
                    </div>
                </div>
                <input class="btn white black-text waves-effect" type="submit" value="Subscribe" />
            </form>
        </div>

    </div>
</div>

<!-- Tessellactation -->
<script src="<?php bloginfo('template_url');?>/js/TweenLite.min.js"></script>
<script src="<?php bloginfo('template_url');?>/js/rAF.min.js"></script>
<script src="<?php bloginfo('template_url');?>/js/EasePack.min.js"></script>
<script src="<?php bloginfo('template_url');?>/js/tessellactation.js"></script>
<?php get_footer(); ?>