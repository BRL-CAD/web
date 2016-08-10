<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>
        <?php if (is_front_page()){echo "Home";} ?>
        <?php wp_title(''); ?> — <?php bloginfo('name'); ?>
    </title>
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link rel="stylesheet" href="<?php bloginfo('template_url');?>/css/materialize.min.css">
    <link type="text/css" rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#D0245E">
    <link rel="icon" sizes="16x16" type="image/ico" href="<?php bloginfo('template_url');?>/img/favicon.ico">
    <?php wp_enqueue_script("jquery");?>
    <?php wp_head();?>
</head>

<body>
    <!-- Navigation -->
    <nav id="navbar">
        <div class="container">
            <div>
                <a href="#" data-activates="slide-out" class="left hide-on-large button-collapse"><i class="material-icons">menu</i></a>
                <a class="white-text logo-link left" href="<?php echo site_url(); ?>">
                    <div id="nav-logo"></div>BRL-CAD
                </a>
            </div>
            <ul class="right nav-list hide-on-med-and-down">
                <li><a class="waves-effect waves-light <?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" == site_url()."/" ? "active " : " "; ?>" href="<?php echo site_url();?>/">HOME</a></li>
                <li><a class="waves-effect waves-light <?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" == site_url()."/download/" ? "active " : " "; ?>" href="<?php echo site_url();?>/download/">DOWNLOAD</a></li>
                <li><a class="waves-effect waves-light <?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" == site_url()."/about/" ? "active " : " "; ?>" href="<?php echo site_url();?>/about/">ABOUT</a></li>
                <li><a class="waves-effect waves-light" href="http://docs.esde.name/">DOCUMENTATION</a></li>
                <li><a class="waves-effect waves-light <?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" == site_url()."/news/" ? "active " : " "; ?>" href="<?php echo site_url();?>/news/">NEWS</a></li>
                <li><a class="waves-effect waves-light <?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" == site_url()."/get-involved/" ? "active " : " "; ?>" href="<?php echo site_url();?>/get-involved/">GET INVOLVED</a></li>
            </ul>
            <!-- Slide out navigation -->
            <ul id="slide-out" class="side-nav">
                <li><a href="<?php echo site_url();?>/">HOME</a></li>
                <li><a href="<?php echo site_url();?>/download/">DOWNLOAD</a></li>
                <li><a href="<?php echo site_url();?>/about/">ABOUT</a></li>
                <li><a href="http://docs.esde.name/">DOCUMENTATION</a></li>
                <li><a href="<?php echo site_url();?>/news/">NEWS</a></li>
                <li><a href="<?php echo site_url();?>/get-involved/">GET INVOLVED</a></li>
            </ul>

        </div>
    </nav>