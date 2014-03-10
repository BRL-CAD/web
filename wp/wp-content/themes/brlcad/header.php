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

            <span class="circle" href="#"> 

                <img src="wp-content/themes/BRL-CAD/images/logo_70.png" width="40px" height="40px"/>

            </span> 

        </div>

        

        <!-- header code starts here -->

		<header class="head">

			 <nav class="navbar"> 

				<ul class="navigation id_main-nav" id="main-nav">				

					<li><a href="">

                        <img class = "icon" src="wp-content/themes/BRL-CAD/images/icons/gallery.png" />

                        Gallery</a></li>

                    <li><a href="">

                        <img class = "icon" src="wp-content/themes/BRL-CAD/images/icons/wiki.png" />

                        Blog</a></li>

                    <li><a href="">

                        <img class = "icon" src="wp-content/themes/BRL-CAD/images/icons/contribute.png" />

                        Community</a></li> 

                    <li><a href="">

                        <img class = "icon" src="wp-content/themes/BRL-CAD/images/icons/documentation.png" />

                        Documentation</a></li>

                    <li><a href="/wp/download/"> 

                        <img class = "icon" src="wp-content/themes/BRL-CAD/images/icons/download-2.png" />

                        Download</a></li>

                    <li class="selected">

                        <a href="#about">

                             <img class = "icon" src="wp-content/themes/BRL-CAD/images/icons/home.png" />

                            About

                        </a>

                    </li>

                    

				</ul>

			</nav>

		</header>
	</div>
	<div id="content" class="site-content">
