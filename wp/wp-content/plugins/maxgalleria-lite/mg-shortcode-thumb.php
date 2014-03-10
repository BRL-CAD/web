<?php
class MGShortcodeThumb {
	function __construct() {
		add_shortcode('maxgallery_thumb', array($this, 'maxgallery_thumb_shortcode'));
	}
	
	function maxgallery_thumb_shortcode($atts) {	
		extract(shortcode_atts(array(
			'id' => '',
			'name' => '',
			'size' => '',
			'width' => '',
			'height' => '',
			'url' => '',
			'target' => ''
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
			$attrs = array(
				'size' => sanitize_text_field("{$size}"),
				'width' => sanitize_text_field("{$width}"),
				'height' => sanitize_text_field("{$height}"),
				'url' => sanitize_text_field("{$url}"),
				'target' => sanitize_text_field("{$target}")
			);
		
			$output = $this->get_output($gallery, $attrs);
		}
		
		return $output;
	}
	
	function get_output($gallery, $attrs) {
		$maxgallery = new MaxGallery($gallery->ID);

		$url = $attrs['url'] != '' ? $attrs['url'] : get_permalink($gallery->ID);
		$target = $attrs['target'] == 'new' ? '_blank' : '';
		$named_size = $this->get_named_thumbnail_size($maxgallery, $attrs['size']);
		$custom_width = $attrs['width'];
		$custom_height = $attrs['height'];
		$use_custom_size = ($custom_width != '' && $custom_height != '') ? true : false;
		
		$output = '<a href="' . $url . '" target="' . $target . '">';
		
		if (has_post_thumbnail($gallery->ID)) {
			// Use the featured image for the gallery
			if ($use_custom_size) {
				$output .= get_the_post_thumbnail($gallery->ID, array($custom_width, $custom_height));
			} else {
				$output .= get_the_post_thumbnail($gallery->ID, $named_size);
			}
		}
		else {
			// If the gallery doesn't have a featured image, then use the first thumbnail from the gallery
			$args = array('post_parent' => $gallery->ID, 'post_type' => 'attachment', 'orderby' => 'menu_order', 'order' => 'asc', 'numberposts' => 1);
			$attachments = get_posts($args);
			
			foreach ($attachments as $attachment) {
				if ($use_custom_size) {
					$output .= wp_get_attachment_image($attachment->ID, array($custom_width, $custom_height));
				} else {
					$output .= wp_get_attachment_image($attachment->ID, $named_size);
				}
				break;
			}
		}
		
		$output .= '</a>';
		return $output;
	}
	
	function get_named_thumbnail_size($maxgallery, $attr_size) {
		$size = '';
		
		if ($maxgallery->is_image_gallery()) {
			if ($attr_size == 'small') $size = MAXGALLERIA_LITE_META_IMAGE_THUMB_SMALL;
			if ($attr_size == 'medium') $size = MAXGALLERIA_LITE_META_IMAGE_THUMB_MEDIUM;
			if ($attr_size == 'large') $size = MAXGALLERIA_LITE_META_IMAGE_THUMB_LARGE;
		}
		
		return $size;
	}
}
?>