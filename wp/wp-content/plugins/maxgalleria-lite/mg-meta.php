<?php
class MGMeta {
	function __construct() {		
		add_action('add_meta_boxes', array($this, 'add_gallery_meta_boxes'));
		add_action('save_post', array($this, 'save_gallery_options'));
	}
	
	function add_gallery_meta_boxes() {
		global $post;
		global $maxgalleria;
		
		$new_gallery = $maxgalleria->new_gallery;
		$image_gallery = $maxgalleria->image_gallery;
		
		if (isset($post)) {
			$maxgallery = new MaxGallery($post->ID);
			
			if ($maxgallery->is_new_gallery()) {
				$this->add_normal_meta_box('new-gallery', __('New Gallery', 'maxgalleria-lite'), array($new_gallery, 'show_meta_box_new_gallery'));
			}
			
			if ($maxgallery->is_image_gallery()) {
				$this->add_side_meta_box('image-gallery-shortcodes', __('Shortcodes', 'maxgalleria-lite'), array($image_gallery, 'show_meta_box_image_gallery_shortcodes'));
				$this->add_side_meta_box('image-gallery-layout', __('Layout', 'maxgalleria-lite'), array($image_gallery, 'show_meta_box_image_gallery_layout'));				
				$this->add_side_meta_box('image-gallery-thumbnails', __('Thumbnails', 'maxgalleria-lite'), array($image_gallery, 'show_meta_box_image_gallery_thumbnails'));
				$this->add_side_meta_box('image-gallery-lightbox', __('Lightbox', 'maxgalleria-lite'), array($image_gallery, 'show_meta_box_image_gallery_lightbox'));
				$this->add_side_meta_box('image-gallery-description', __('Description', 'maxgalleria-lite'), array($image_gallery, 'show_meta_box_image_gallery_description'));
				$this->add_side_meta_box('image-gallery-advanced', __('Advanced', 'maxgalleria-lite'), array($image_gallery, 'show_meta_box_image_gallery_advanced'));
				$this->add_normal_meta_box('image-gallery-images', __('Images', 'maxgalleria-lite'), array($image_gallery, 'show_meta_box_image_gallery_images'));
			}
		}
	}
	
	function add_side_meta_box($id, $title, $callback) {
		$id = $id;
		$title = $title;
		$callback = $callback;
		$post_type = MAXGALLERIA_LITE_POST_TYPE;
		$context = 'side';
		$priority = 'default';
		add_meta_box($id, $title, $callback, $post_type, $context, $priority);
	}

	function add_normal_meta_box($id, $title, $callback) {
		$id = $id;
		$title = $title;
		$callback = $callback;
		$post_type = MAXGALLERIA_LITE_POST_TYPE;
		$context = 'normal';
		$priority = 'high';
		add_meta_box($id, $title, $callback, $post_type, $context, $priority);
	}
	
	function save_gallery_options() {
		global $post;

		if (isset($post)) {
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
				return $post->ID;
			}

			if (!current_user_can('edit_post', $post->ID)) {
				return $post->ID;
			}
			
			$maxgallery = new MaxGallery($post->ID);
			$maxgallery->save_options();
		}
	}
}
?>