<?php
/*
Plugin Name: MaxGalleria Lite
Plugin URI: http://maxgalleria.com
Description: Create great-looking responsive image galleries with ease. This is the lite version; the full version <a href="http://maxgalleria.com/?ref=mglite">can be found here</a>.
Version: 1.1.2
Author: Max Foundry
Author URI: http://maxfoundry.com

Copyright 2013 Max Foundry, LLC (http://maxfoundry.com)
*/

class MaxGalleriaLite {
	public $admin;
	public $common;
	public $meta;
	public $nextgen;
	public $shortcode;
	public $shortcode_thumb;
	public $tinymce;
	public $new_gallery;
	public $image_gallery;
	
	function __construct() {
		$this->set_global_constants();
		$this->set_activation_hooks();
		$this->initialize_properties();
		$this->setup_hooks();
		$this->add_thumb_sizes();
	}
	
	function activate() {
		update_option(MAXGALLERIA_LITE_VERSION_KEY, MAXGALLERIA_LITE_VERSION_NUM);
		
		// Copy gallery post type template file to theme directory
		$source = MAXGALLERIA_LITE_PLUGIN_DIR . '/templates/single-maxgallery.php';
		$destination = $this->get_theme_dir() . '/single-maxgallery.php';
		copy($source, $destination);
		
		flush_rewrite_rules();
	}
	
	function add_thumb_sizes() {
		// In addition to the thumbnail support when registering the custom post type, we need to add theme support
		// to properly handle the featured image for a gallery, just in case the theme itself doesn't have it.
		add_theme_support('post-thumbnails');
		
		// Additional sizes, cropped
		add_image_size(MAXGALLERIA_LITE_META_IMAGE_THUMB_SMALL, 100, 100, true);
		add_image_size(MAXGALLERIA_LITE_META_IMAGE_THUMB_MEDIUM, 150, 150, true);
		add_image_size(MAXGALLERIA_LITE_META_IMAGE_THUMB_LARGE, 200, 200, true);
	}

	function admin_page_is_gallery_post_type() {
		global $post_type;
		
		if ((isset($_GET['post_type']) && $_GET['post_type'] == MAXGALLERIA_LITE_POST_TYPE) || ($post_type == MAXGALLERIA_LITE_POST_TYPE)) {
			return true;
		}
		
		return false;
	}
	
	function admin_page_is_media_edit() {
		if ($this->common->url_contains('wp-admin/media.php') && $this->common->url_contains('action=edit')) {
			return true;
		}
		
		return false;
	}
	
	function call_function_for_each_site($function) {
		global $wpdb;
		
		// Hold this so we can switch back to it
		$current_blog = $wpdb->blogid;
		
		// Get all the blogs/sites in the network and invoke the function for each one
		$blog_ids = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs"));
		foreach ($blog_ids as $blog_id) {
			switch_to_blog($blog_id);
			call_user_func($function);
		}
		
		// Now switch back to the root blog
		switch_to_blog($current_blog);
	}
	
	function create_gallery_columns($column) {
		// The Title and Date columns are standard, so we don't have to explicitly provide output for them
		
		global $post;
		$maxgallery = new MaxGallery($post->ID);

		if ($maxgallery->get_template_display() == 'Image Tiles') {
			// Get all the attachments (the -1 gets all of them)
			$args = array('post_parent' => $post->ID, 'post_type' => 'attachment', 'orderby' => 'menu_order', 'order' => 'asc', 'numberposts' => -1);
			$attachments = get_posts($args);
			
			// Rounded borders
			$style = 'border-radius: 2px; -moz-border-radius: 2px; -webkit-border-radius: 2px;';
			
			switch ($column) {
				case 'thumbnail':
					if (has_post_thumbnail($post->ID)) {
						echo get_the_post_thumbnail($post->ID, array(32, 32), array('style' => $style));
					}
					else {
						foreach ($attachments as $attachment) {
							$no_media_icon = 0;
							echo wp_get_attachment_image($attachment->ID, array(32, 32), $no_media_icon, array('style' => $style));
							break;
						}
					}
					break;
				case 'template':
					echo $maxgallery->get_template_display();
					break;
				case 'number':
					if ($maxgallery->is_image_gallery()) {
						if (count($attachments) == 0) { _e('0 images', 'maxgalleria-lite'); }
						if (count($attachments) == 1) { _e('1 image', 'maxgalleria-lite'); }
						if (count($attachments) > 1) { printf(__('%d images', 'maxgalleria-lite'), count($attachments)); }
					}
					break;
				case 'shortcode':
					echo '[maxgallery id="' . $post->ID . '"]';
					
					if ($post->post_status == 'publish') {
						echo '<br />';
						echo '[maxgallery name="' . $post->post_name . '"]';
					}
					break;
			}
		}
		else {
			echo '<script type="text/javascript">';
			echo 'jQuery(document).ready(function() {';
			echo '	jQuery("tr#post-' . $post->ID . '").hide();';
			echo '});';
			echo '</script>';
		}
	}
	
	function create_plugin_action_links($links, $file) {
		static $this_plugin;
		
		if (!$this_plugin) {
			$this_plugin = plugin_basename(__FILE__);
		}
		
		if ($file == $this_plugin) {
			$packs_link = '<a href="' . admin_url() . 'edit.php?post_type=' . MAXGALLERIA_LITE_POST_TYPE . '">' . __('Galleries', 'maxgalleria-lite') . '</a>';
			array_unshift($links, $packs_link);
		}

		return $links;
	}
	
	function create_sortable_gallery_columns($vars) {
		if (isset($vars['orderby'])) {
			switch ($vars['orderby']) {
				case 'type':
					$vars = array_merge($vars, array('meta_key' => 'maxgallery_type', 'orderby' => 'meta_value'));
					break;
				case 'template':
					$vars = array_merge($vars, array('meta_key' => 'maxgallery_template', 'orderby' => 'meta_value'));
					break;
			}
		}
		
		return $vars;
	}
	
	function deactivate() {
		delete_option(MAXGALLERIA_LITE_VERSION_KEY);
		
		// Delete the gallery post type template file from the theme directory
		$file = $this->get_theme_dir() . '/single-maxgallery.php';
		unlink($file);
		
		flush_rewrite_rules();
	}
	
	function define_gallery_columns($columns) {
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __('Title', 'maxgalleria-lite'),
			'thumbnail' => __('Thumbnail', 'maxgalleria-lite'),
			'template' => __('Template', 'maxgalleria-lite'),
			'number' => __('Number of Media', 'maxgalleria-lite'),
			'shortcode' => __('Shortcode', 'maxgalleria-lite'),
			'date' => __('Date', 'maxgalleria-lite')
		);
		
		return $columns;
	}
	
	function define_sortable_gallery_columns($columns) {		
		// Title and Date are sortable by default

		$columns['type'] = 'type';
		$columns['template'] = 'template';
		$columns['number'] = 'number';
		
		return $columns;
	}
	
	function do_activation($network_wide) {
		if ($network_wide) {
			$this->call_function_for_each_site(array($this, 'activate'));
		}
		else {
			$this->activate();
		}
	}
	
	function do_deactivation($network_wide) {	
		if ($network_wide) {
			$this->call_function_for_each_site(array($this, 'deactivate'));
		}
		else {
			$this->deactivate();
		}
	}
	
	function enqueue_admin_print_scripts() {
		if ($this->admin_page_is_gallery_post_type()) {
			wp_enqueue_script('thickbox');
			wp_enqueue_script('media-upload');
			wp_enqueue_script('jquery-ui-core');
			wp_enqueue_script('jquery-ui-slider');
			wp_enqueue_script('jquery-ui-accordion');
			wp_enqueue_script('maxgalleria-datatables', MAXGALLERIA_LITE_PLUGIN_URL . '/libs/datatables/jquery.dataTables.min.js', array('jquery'));
			wp_enqueue_script('maxgalleria-datatables-row-reordering', MAXGALLERIA_LITE_PLUGIN_URL . '/libs/datatables/jquery.dataTables.rowReordering.js', array('jquery'));
			wp_enqueue_script('maxgalleria-fancybox', MAXGALLERIA_LITE_PLUGIN_URL . '/libs/fancybox/jquery.fancybox-1.3.4.pack.js', array('jquery'));
			wp_enqueue_script('maxgalleria-easing', MAXGALLERIA_LITE_PLUGIN_URL . '/libs/fancybox/jquery.easing-1.3.pack.js', array('jquery'));
			wp_enqueue_script('maxgalleria-simplemodal', MAXGALLERIA_LITE_PLUGIN_URL . '/libs/simplemodal/jquery.simplemodal-1.4.3.min.js', array('jquery'));
		}
	}

	function enqueue_admin_print_styles() {		
		if ($this->admin_page_is_gallery_post_type()) {
			wp_enqueue_style('thickbox');
			wp_enqueue_style('maxgalleria-jquery-ui', MAXGALLERIA_LITE_PLUGIN_URL . '/libs/jquery-ui/jquery-ui.css');
			wp_enqueue_style('maxgalleria-fancybox', MAXGALLERIA_LITE_PLUGIN_URL . '/libs/fancybox/jquery.fancybox-1.3.4.css');
			wp_enqueue_style('maxgalleria-simplemodal', MAXGALLERIA_LITE_PLUGIN_URL . '/libs/simplemodal/simplemodal.css');
			wp_enqueue_style('maxgalleria', MAXGALLERIA_LITE_PLUGIN_URL . '/maxgalleria.css');
		}
	}
	
	function get_theme_dir() {
		return ABSPATH . 'wp-content/themes/' . get_template();
	}
	
	function initialize_properties() {
		// The order doesn't really matter, except maxgallery.php must be included first so
		// that the MaxGallery class can be created in other parts of the system as needed
		
		require_once 'maxgallery.php';
		require_once 'mg-admin.php';
		require_once 'mg-common.php';
		require_once 'mg-meta.php';
		require_once 'mg-nextgen.php';
		require_once 'mg-shortcode.php';
		require_once 'mg-shortcode-thumb.php';
		require_once 'mg-tinymce.php';
		require_once 'mg-new-gallery.php';
		require_once 'mg-image-gallery.php';
		
		$this->admin = new MGAdmin();
		$this->common = new MGCommon();
		$this->meta = new MGMeta();
		$this->nextgen = new MGNextGen();
		$this->shortcode = new MGShortcode();
		$this->shortcode_thumb = new MGShortcodeThumb();
		$this->tinymce = new MGTinyMce();
		$this->new_gallery = new MGNewGallery();
		$this->image_gallery = new MGImageGallery();
	}
	
	function load_textdomain() {
		load_plugin_textdomain('maxgalleria-lite', false, dirname(plugin_basename(__FILE__)) . '/languages/');
	}
	
	function register_gallery_post_type() {
		$labels = array(
			'name' => __('Galleries', 'maxgalleria-lite'),
			'singular_name' => __('Gallery', 'maxgalleria-lite'),
			'add_new' => __('Add New', 'maxgalleria-lite'),
			'add_new_item' => __('Add New Gallery', 'maxgalleria-lite'),
			'edit_item' => __('Edit Gallery', 'maxgalleria-lite'),
			'new_item' => __('New Gallery', 'maxgalleria-lite'),
			'view_item' => __('View Gallery', 'maxgalleria-lite'),
			'search_items' => __('Search Galleries', 'maxgalleria-lite'),
			'not_found' => __('No galleries found', 'maxgalleria-lite'),
			'not_found_in_trash' => __('No galleries found in trash', 'maxgalleria-lite'),
			'parent_item_colon' => ''
		);
		
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'query_var' => true,
			'menu_icon' => MAXGALLERIA_LITE_PLUGIN_URL . '/images/maxgalleria-icon-16.png',
			'rewrite' => array('slug' => __('gallery', 'maxgalleria-lite')),
			'capability_type' => 'post',
			'hierarchical' => false,
			'supports' => array('title', 'thumbnail')
		);
		
		register_post_type(MAXGALLERIA_LITE_POST_TYPE, $args);
	}
	
	function set_activation_hooks() {
		register_activation_hook(__FILE__, array($this, 'do_activation'));
		register_deactivation_hook(__FILE__, array($this, 'do_deactivation'));
	}
	
	function set_global_constants() {	
		define('MAXGALLERIA_LITE_VERSION_KEY', 'maxgalleria_lite_version');
		define('MAXGALLERIA_LITE_VERSION_NUM', '1.1.2');
		define('MAXGALLERIA_LITE_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));
		define('MAXGALLERIA_LITE_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . MAXGALLERIA_LITE_PLUGIN_NAME);
		define('MAXGALLERIA_LITE_PLUGIN_URL', WP_PLUGIN_URL . '/' . MAXGALLERIA_LITE_PLUGIN_NAME);
		define('MAXGALLERIA_LITE_POST_TYPE', 'maxgallery');
		define('MAXGALLERIA_LITE_META_IMAGE_THUMB_SMALL', 'maxgallery-meta-image-thumb-small');
		define('MAXGALLERIA_LITE_META_IMAGE_THUMB_MEDIUM', 'maxgallery-meta-image-thumb-medium');
		define('MAXGALLERIA_LITE_META_IMAGE_THUMB_LARGE', 'maxgallery-meta-image-thumb-large');
		define('MAXGALLERIA_LITE_THUMB_SHAPE_LANDSCAPE', 'landscape');
		define('MAXGALLERIA_LITE_THUMB_SHAPE_PORTRAIT', 'portrait');
		define('MAXGALLERIA_LITE_THUMB_SHAPE_SQUARE', 'square');
		define('MAXGALLERIA_LITE_TEMPLATE_IMAGE_TILES', 'image-tiles');
	}
	
	function set_icon_edit_image() {
		if ($this->admin_page_is_gallery_post_type()) {
			echo '<style>';
			echo '#icon-edit { background: url("'. MAXGALLERIA_LITE_PLUGIN_URL . '/images/maxgalleria-icon-32.png' . '") no-repeat transparent; }';
			echo '</style>';
		}
	}
	
	function setup_hooks() {
		add_action('init', array($this, 'load_textdomain'));
		add_action('init', array($this, 'register_gallery_post_type'));
		add_filter('plugin_action_links', array($this, 'create_plugin_action_links'), 10, 2);
		add_action('admin_print_scripts', array($this, 'enqueue_admin_print_scripts'));
		add_action('admin_print_styles', array($this, 'enqueue_admin_print_styles'));
		add_action('admin_head', array($this, 'set_icon_edit_image'));
		add_filter('manage_edit-' . MAXGALLERIA_LITE_POST_TYPE . '_columns', array($this, 'define_gallery_columns'));
		add_filter('manage_edit-' . MAXGALLERIA_LITE_POST_TYPE . '_sortable_columns', array($this, 'define_sortable_gallery_columns'));
		add_action('manage_posts_custom_column', array($this, 'create_gallery_columns'));
		add_filter('request', array($this, 'create_sortable_gallery_columns'));
	}
	
	function thickbox_l10n_fix() {
		// When combining scripts, localization is lost for thickbox.js, so we call this
		// function to fix it. See http://wordpress.org/support/topic/plugin-affecting-photo-galleriessliders
		// for more details.
		echo '<script type="text/javascript">';
		echo "var thickboxL10n = " . json_encode(array(
			'next' => __('Next >'),
			'prev' => __('< Prev'),
			'image' => __('Image'),
			'of' => __('of'),
			'close' => __('Close'),
			'noiframes' => __('This feature requires inline frames. You have iframes disabled or your browser does not support them.'),
			'loadingAnimation' => includes_url('js/thickbox/loadingAnimation.gif'),
			'closeImage' => includes_url('js/thickbox/tb-close.png')));
		echo '</script>';
	}
}

// Let's get this party started
$maxgalleria = new MaxGalleriaLite();
?>