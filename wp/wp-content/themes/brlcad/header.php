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

<body <?php //body_class(); ?>>
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<header class="site-header" role="banner">
		<div class="menu-toggle show-for-medium-down"></div>
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<div class="row">
				<h1 id="logo" class="left show-for-large-up"><a href="<?php echo home_url(); ?>" id="logo"></a></h1>
				<?php wp_nav_menu( array( 'menu' => 'primary' ) ); ?>
			</div>
		</nav>
	</header>

	<div id="content" class="site-content">
