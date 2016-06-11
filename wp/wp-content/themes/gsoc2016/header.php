<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php wp_title()?><?php bloginfo('name'); ?></title>
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/css/materialize.min.css">
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
            <div class="left">
                <a href="#" data-activates="slide-out" class="left hide-on-large button-collapse"><i class="material-icons">menu</i></a>
                <a class="white-text" href="<?php echo site_url(); ?>">
                    <div id="nav-logo"></div>BRL-CAD</a>
            </div>
            <ul class="right nav-list hide-on-med-and-down">
                <li><a class="waves-effect waves-light active" href="index.html">HOME</a></li>
                <li><a class="waves-effect waves-light" href="download.html">DOWNLOAD</a></li>
                <li><a class="waves-effect waves-light" href="about.html">ABOUT</a></li>
                <li><a class="waves-effect waves-light" href="http://brlcad.org/wiki/Documentation">DOCUMENTATION</a></li>
                <li><a class="waves-effect waves-light" href="news.html">NEWS</a></li>
                <li><a class="waves-effect waves-light" href="getinvolved.html">GET INVOLVED</a></li>
            </ul>
            <!-- Slide out navigation -->
            <ul id="slide-out" class="side-nav">
                <li><a href="index.html">HOME</a></li>
                <li><a href="download.html">DOWNLOAD</a></li>
                <li><a href="about.html">ABOUT</a></li>
                <li><a href="http://brlcad.org/wiki/Documentation">DOCUMENTATION</a></li>
                <li><a href="news.html">NEWS</a></li>
                <li><a href="getinvolved.html">GET INVOLVED</a></li>
            </ul>

        </div>
    </nav>