<?php
    /**
     * The Header for our theme.
     *
    <span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
     * Displays all of the <head> section and everything up till <div id="content">
     *
     * @package brlcad
     */
    ?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php wp_title( '|', true, 'right' ); ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
        <?php wp_head(); ?>
    </head>
    <body <?php //body_class(); ?>>
        <div id="page" class="hfeed site">
        <?php do_action( 'before' ); ?>
        <!-- header code starts here -->
        <header class="head">
				
            <nav class="navbar navbar-default navbar-static-top">
			<div class="container">
				<div class="navbar-header">
                    <!-- the circular logo that also works as menu toggle -->
                    <!--<a href="<?php echo '#'//esc_url( home_url( '/' ) ); ?>" class="navbar-toggle collapsed" data-toggle="collapse" data-target="brlcad-navbar-collapse-1" aria-expanded="false">
                        </a> -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#brlcad-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" style="padding: 10px; line-height: 50px">
                    <span class="logo"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/logo_70.png"/></span>
                    <b>BRL-CAD</b>
                    </a>
                </div>
                <div class="collapse navbar-collapse navbar-right" id="brlcad-navbar-collapse-1">
                    <ul class="nav navbar-nav" id="main-nav">
                        <li class="active">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>#about">
                                <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
                                About
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url( home_url( '/download/' ) ); ?>">
                                <span class="glyphicon glyphicon-cloud-download" aria-hidden="true"></span>
                                Download
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url( home_url( '../wiki/Documentation' ) ); ?>">
                                <span class="fa fa-file-text" aria-hidden="true"></span>
                                Documentation
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url( home_url( '../wiki/' ) ); ?>">
                                <span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
                                Community
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">
                                <span class="glyphicon glyphicon-book" aria-hidden="true"></span>
                                Blog
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url( home_url( '../gallery/' ) ); ?>">
                                <!--                        <img class = "icon" src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/gallery.png" />-->
                                <span class="glyphicon glyphicon-picture" aria-hidden="true"></span>
                                Gallery
                            </a>
                        </li>
                    </ul>
                </div>
				
			</div>
            </nav>
        </header>
        <div id="content" class="site-content">
