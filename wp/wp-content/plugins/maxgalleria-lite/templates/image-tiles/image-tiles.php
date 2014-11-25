<?php
class MGImageTiles {
	function enqueue_styles($maxgallery) {
		// Check to add lightbox styles
		if ($maxgallery->get_thumb_click() == 'lightbox') {
			wp_enqueue_style('maxgalleria-fancybox', MAXGALLERIA_LITE_PLUGIN_URL . '/libs/fancybox/jquery.fancybox-1.3.4.css');
		}
		
		// The main styles for this template
		wp_enqueue_style('maxgalleria-image-tiles', MAXGALLERIA_LITE_PLUGIN_URL . '/templates/image-tiles/image-tiles.css');
		
		// Load skin style
		$skin = $maxgallery->get_skin();
		wp_enqueue_style('maxgalleria-image-tiles-skin-' . $skin, MAXGALLERIA_LITE_PLUGIN_URL . '/templates/image-tiles/image-tiles-skin-' . $skin . '.css');
	}

	function enqueue_scripts($maxgallery) {
		wp_enqueue_script('jquery');
		
		if ($maxgallery->get_thumb_click() == 'lightbox') {
			wp_enqueue_script('maxgalleria-fancybox', MAXGALLERIA_LITE_PLUGIN_URL . '/libs/fancybox/jquery.fancybox-1.3.4.pack.js', array('jquery'));
			wp_enqueue_script('maxgalleria-easing', MAXGALLERIA_LITE_PLUGIN_URL . '/libs/fancybox/jquery.easing-1.3.pack.js', array('jquery'));
			wp_enqueue_script('maxgalleria-image-tiles', MAXGALLERIA_LITE_PLUGIN_URL . '/templates/image-tiles/image-tiles.js', array('jquery'));

			$data = array(
				'lightbox_caption_enabled' => $maxgallery->get_lightbox_caption_enabled(),
				'lightbox_caption_position' => $maxgallery->get_lightbox_caption_position()
			);
			wp_localize_script('maxgalleria-image-tiles', 'maxgallery', $data);
		}
	}

	function get_output($gallery, $attachments) {
		global $maxgalleria;
		$image_gallery = $maxgalleria->image_gallery;
		
		$maxgallery = new MaxGallery($gallery->ID);

		$this->enqueue_styles($maxgallery);
		$this->enqueue_scripts($maxgallery);
		
		$output = '<div id="maxgalleria-' . $gallery->ID . '" class="mg-image-tiles">';
		
		if ($maxgallery->get_description_enabled() == 'on' && $maxgallery->get_description_position() == 'above') {
			if ($maxgallery->get_description_text() != '') {
				$output .= '<p class="mg-description">' . $maxgallery->get_description_text() . '</p>';
			}
		}
		
		$output .= '	<div class="mg-thumbs ' . $maxgallery->get_thumb_columns_class() . '">';
		$output .= '		<ul>';

		foreach ($attachments as $attachment) {
			$excluded = get_post_meta($attachment->ID, 'maxgallery_attachment_image_exclude', true);
			if (!$excluded) {
				$title = $attachment->post_title;
				$caption = $attachment->post_excerpt; // Used for the thumb and lightbox captions, if enabled
				$alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
				$link = get_post_meta($attachment->ID, 'maxgallery_attachment_image_link', true);

				// Default to original, full size image
				$href = $attachment->guid;
				$target = '';
				
				if ($maxgallery->get_thumb_click() == 'lightbox') {
					if ($maxgallery->get_lightbox_image_size() == 'custom') {
						$lightbox_image = $image_gallery->get_lightbox_image($maxgallery, $attachment);
						$href = $lightbox_image['url'];
					}
				}
				
				if ($maxgallery->get_thumb_click() == 'attachment_image_page') {
					$href = get_attachment_link($attachment->ID);
				}
				
				if ($maxgallery->get_thumb_click() == 'attachment_image_link') {
					if ($link != '') {
						$href = $link;
					}
				}
				
				if ($maxgallery->get_thumb_click_new_window() == 'on') {
					$target = '_blank';
				}
				
				$thumb_image = $image_gallery->get_thumb_image($maxgallery, $attachment);
				
				$output .= '<li>';
				$output .= "	<a href='" . $href . "' target='" . $target . "' rel='mg-thumbs' title='" . $caption . "'>";
				$output .= '		<div>';
				$output .= '			<img src="' . $thumb_image['url'] . '" width="' . $thumb_image['width'] . '" height="' . $thumb_image['height'] . '" alt="' . $alt . '" title="' . $title . '" />';
				
				if ($maxgallery->get_thumb_caption_enabled() == 'on' && $maxgallery->get_thumb_caption_position() == 'bottom') {
					$output .= '		<div class="caption-bottom-container">';
					$output .= '			<p class="caption bottom">' . $caption . '</p>';
					$output .= '		</div>';
				}
				
				$output .= '		</div>';
				$output .= '	</a>';
				
				if ($maxgallery->get_thumb_caption_enabled() == 'on' && $maxgallery->get_thumb_caption_position() == 'below') {
					$output .= '	<p class="caption below">' . $caption . '</p>';
				}
				
				$output .= '</li>';
			}
		}

		$output .= '		</ul>';
		$output .= '		<div class="clear"></div>';
		
		if ($maxgallery->get_description_enabled() == 'on' && $maxgallery->get_description_position() == 'below') {
			if ($maxgallery->get_description_text() != '') {
				$output .= '<p class="mg-description">' . $maxgallery->get_description_text() . '</p>';
			}
		}
		
		$output .= '	</div>';
		$output .= '</div>';
		
		return $output;
	}
}
?>