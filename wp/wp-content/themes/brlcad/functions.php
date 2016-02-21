<?php
/**
 * brlcad functions and definitions
 *
 * @package brlcad
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'brlcad_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function brlcad_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on brlcad, use a find and replace
	 * to change 'brlcad' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'brlcad', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'brlcad' ),
		'sidebar' => __( 'Sidebar Menu' )
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'brlcad_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // brlcad_setup
add_action( 'after_setup_theme', 'brlcad_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function brlcad_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'brlcad' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Left Sidebar', 'brlcad' ),
		'id'            => 'footer-sidebar-left',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));
	register_sidebar( array(
		'name'          => __( 'Footer Center Sidebar', 'brlcad' ),
		'id'            => 'footer-sidebar-center',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));
	register_sidebar( array(
		'name'          => __( 'Footer Right Sidebar', 'brlcad' ),
		'id'            => 'footer-sidebar-right',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));
}
add_action( 'widgets_init', 'brlcad_widgets_init' );

/**
 * Enqueue scripts and styles.
 */

/* load Google's CDN */
function sp_load_jquery() {
    if ( ! is_admin() && !wp_script_is( 'jquery' ) ) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js", false, null);
        wp_enqueue_script('jquery');
    }
    if ( ! is_admin() && !wp_script_is( 'jquery' ) ) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js", false, null);
        wp_enqueue_script('jquery');
    }
}
add_action('wp_enqueue_scripts', 'sp_load_jquery');

function brlcad_scripts() {
	wp_enqueue_style( 'foundation', get_template_directory_uri() . '/css/foundation.min.css' );
	wp_enqueue_style( 'fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css' );
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/bootstrap-3.3.5/dist/css/bootstrap.css' );
	
	wp_enqueue_style( 'brl-cadbase', get_template_directory_uri() . '/css/base.css' );

	wp_enqueue_style( 'brl-media-queries', get_template_directory_uri() . '/css/media-queries.css' );

	wp_enqueue_style( 'brl-plugins', get_template_directory_uri() . '/css/plugins.css' );

	wp_enqueue_style( 'brlcad-style', get_stylesheet_uri() );

	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '20131224', true );

	wp_enqueue_script( 'brlcad-main', get_template_directory_uri() . '/js/main.js', array('jquery'), '20131224', true );

	wp_enqueue_script( 'brlcad-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'brlcad-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'brlcad_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
