<?php
class MGNewGallery {
	function __construct() {
		add_action('wp_ajax_save_new_gallery_type', array($this, 'save_new_gallery_type'));
		add_action('wp_ajax_nopriv_save_new_gallery_type', array($this, 'save_new_gallery_type'));
	}

	function save_new_gallery_type() {	
		$maxgallery = new MaxGallery($_POST['post_ID']);
		$maxgallery->add_update_post_meta($maxgallery->type_key);

		echo $_POST['post_ID'];
		die();
	}
	
	function show_meta_box_new_gallery($post) {
		require_once 'meta/new-gallery-type.php';
	}
}
?>