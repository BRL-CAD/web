<?php
class MGShortcode {
	function __construct() {
		add_shortcode('maxgallery', array($this, 'maxgallery_shortcode'));
	}
	
	function maxgallery_shortcode($atts) {	
		extract(shortcode_atts(array(
			'id' => '',
			'name' => ''
		), $atts));
		
		$gallery_id = sanitize_text_field("{$id}");
		$gallery_name = sanitize_text_field("{$name}");
		
		$output = '';
		$gallery = null;
		
		if ($gallery_id != '' && $gallery_name != '') {
			// If both given, the id wins
			$gallery = get_post($gallery_id);
		}

		if ($gallery_id != '' && $gallery_name == '') {
			// Get the gallery by id
			$gallery = get_post($gallery_id);
		}
		
		if ($gallery_id == '' && $gallery_name != '') {
			// Get the gallery by name
			$query = new WP_Query(array('name' => $gallery_name, 'post_type' => MAXGALLERIA_LITE_POST_TYPE));
			$gallery = $query->get_queried_object();
		}
		
		if (isset($gallery) && $gallery->post_status == 'publish') {
			$maxgallery = new MaxGallery($gallery->ID);
			$template = $maxgallery->get_template();
			
			$args = array(
				'post_type' => 'attachment',
				'numberposts' => -1, // All of them
				'post_parent' => $gallery->ID,
				'orderby' => 'menu_order',
				'order' => 'ASC'
			);

			$attachments = get_posts($args);
			
			if (count($attachments) > 0) {
				$template_obj = null;
				
				switch ($template) {
					case MAXGALLERIA_LITE_TEMPLATE_IMAGE_TILES:
						require_once 'templates/image-tiles/image-tiles.php';
						$template_obj = new MGImageTiles();
						break;
				}
				
				if (isset($template_obj)) {
					$output = $template_obj->get_output($gallery, $attachments);
				}
			}
		}
		
		return $output;
	}
}
?>