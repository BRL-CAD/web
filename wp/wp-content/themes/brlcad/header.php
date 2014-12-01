<?php
/**
 * The Header for our theme.
 *
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

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<div class="h-container">
        <!-- the circular logo that also works as menu toggle -->
		<div class="id_logo" id='logo'>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <span class="circle" href="#"> 
                    <img src="<?php bloginfo('stylesheet_directory'); ?>/images/logo_70.png" width="40px" height="40px"/>
                </span> 
            </a>
        </div>

        <!-- header code starts here -->
		<header class="head">
			 <nav class="navbar"> 
				<ul class="navigation id_main-nav" id="main-nav">				
					<li><a href="<?php echo esc_url( home_url( '../gallery/' ) ); ?>">
                        <img class = "icon" src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/gallery.png" />
                        Gallery</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">
                        <img class = "icon" src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/wiki.png" />
                        Blog</a></li>
                    <li><a href="<?php echo esc_url( home_url( '../wiki/' ) ); ?>">
                        <img class = "icon" src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/contribute.png" />
                        Community</a></li> 
                    <li><a href="<?php echo esc_url( home_url( '../wiki/Documentation' ) ); ?>">
                        <img class = "icon" src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/documentation.png" />
                        Documentation</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/download/' ) ); ?>"> 
                        <img class = "icon" src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/download-2.png" />
                        Download</a></li>
                    <li class="selected">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>#about">
                             <img class = "icon" src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/home.png" />
                            About
                        </a>
                    </li>
				</ul>
			</nav>
		</header>
	</div>
	<div id="content" class="site-content">
