<?php
class MaxGallery {
	private $_post_id;

	function __construct($post_id) {
		$this->_post_id = $post_id;
	}
	
	public function get_post_id() {
		return $this->_post_id;
	}
	
	public function get_post_meta($meta_key) {
		return get_post_meta($this->get_post_id(), $meta_key, true);
	}
	
	public function delete_post_meta($meta_key) {
		delete_post_meta($this->get_post_id(), $meta_key);
	}
	
	public function add_update_post_meta($meta_key) {
		$post_id = $this->get_post_id();
		
		$meta_old_value = get_post_meta($post_id, $meta_key, true);
		$meta_new_value = isset($_POST[$meta_key]) ? stripslashes($_POST[$meta_key]) : '';
		
		if (get_post_meta($post_id, $meta_key) == '') {
			add_post_meta($post_id, $meta_key, $meta_new_value, true);
		}
		elseif ($meta_new_value != $meta_old_value) {
			update_post_meta($post_id, $meta_key, $meta_new_value);
		}
		//elseif ($meta_new_value == '') {
		//	delete_post_meta($post_id, $meta_key, $meta_old_value);
		//}
	}

	public $description_enabled_default = '';
	public $description_enabled_key = 'maxgallery_description_enabled';
	public $description_position_default = 'above';
	public $description_position_key = 'maxgallery_description_position';
	public $description_text_key = 'maxgallery_description_text';
	public $lightbox_caption_enabled_default = '';
	public $lightbox_caption_enabled_key = 'maxgallery_lightbox_caption_enabled';
	public $lightbox_caption_position_default = 'below';
	public $lightbox_caption_position_key = 'maxgallery_lightbox_caption_position';
	public $lightbox_enabled_default = 'yes';
	public $lightbox_enabled_key = 'maxgallery_lightbox_enabled';
	public $lightbox_image_size_custom_height_key = 'maxgallery_lightbox_image_size_custom_height';
	public $lightbox_image_size_custom_width_key = 'maxgallery_lightbox_image_size_custom_width';
	public $lightbox_image_size_default = 'full';
	public $lightbox_image_size_key = 'maxgallery_lightbox_image_size';
	public $reset_options_default = '';
	public $reset_options_key = 'maxgallery_reset_options';
	public $skin_default = 'standard';
	public $skin_key = 'maxgallery_skin';
	public $template_default_image = MAXGALLERIA_LITE_TEMPLATE_IMAGE_TILES;
	public $template_key = 'maxgallery_template';
	public $thumb_caption_enabled_default = '';
	public $thumb_caption_enabled_key = 'maxgallery_thumb_caption_enabled';
	public $thumb_caption_position_default = 'below';
	public $thumb_caption_position_key = 'maxgallery_thumb_caption_position';
	public $thumb_click_default = 'lightbox';
	public $thumb_click_key = 'maxgallery_thumb_click';
	public $thumb_click_new_window_default = '';
	public $thumb_click_new_window_key = 'maxgallery_thumb_click_new_window';
	public $thumb_columns_default = 5;
	public $thumb_columns_key = 'maxgallery_thumb_columns';
	public $thumb_opacity_enabled_default = '';
	public $thumb_opacity_enabled_key = 'maxgallery_thumb_opacity_enabled';
	public $thumb_shape_default_image = MAXGALLERIA_LITE_THUMB_SHAPE_SQUARE;
	public $thumb_shape_key = 'maxgallery_thumb_shape';
	public $type_key = 'maxgallery_type';
	
	public function get_description_enabled() {
		$value = $this->get_post_meta($this->description_enabled_key); 
		if ($value == '') {
			$value = $this->description_enabled_default;
		}
		
		return $value;
	}
	
	public function get_description_position() {
		$value = $this->get_post_meta($this->description_position_key);
		if ($value == '') {
			$value = $this->description_position_default;
		}
		
		return $value;
	}
	
	public function get_description_text() {
		return $this->get_post_meta($this->description_text_key);
	}
	
	public function get_lightbox_caption_enabled() {
		$value = $this->get_post_meta($this->lightbox_caption_enabled_key);
		if ($value == '') {
			$value = $this->lightbox_caption_enabled_default;
		}
		
		return $value;
	}
	
	public function get_lightbox_caption_position() {
		$value = $this->get_post_meta($this->lightbox_caption_position_key);
		if ($value == '') {
			$value = $this->lightbox_caption_position_default;
		}
		
		return $value;
	}
	
	public function get_lightbox_enabled() {
		$value = $this->get_post_meta($this->lightbox_enabled_key); 
		if ($value == '') {
			$value = $this->lightbox_enabled_default;
		}
		
		return $value;
	}
	
	public function get_lightbox_image_size() {
		$value = $this->get_post_meta($this->lightbox_image_size_key);
		if ($value == '') {
			$value = $this->lightbox_image_size_default;
		}
		
		return $value;
	}
	
	public function get_lightbox_image_size_custom_height() {
		return $this->get_post_meta($this->lightbox_image_size_custom_height_key);
	}
	
	public function get_lightbox_image_size_custom_width() {
		return $this->get_post_meta($this->lightbox_image_size_custom_width_key);
	}
	
	public function get_reset_options() {
		$value = $this->get_post_meta($this->reset_options_key); 
		if ($value == '') {
			$value = $this->reset_options_default;
		}
		
		return $value;
	}
	
	public function get_skin() {
		$value = $this->get_post_meta($this->skin_key);
		if ($value == '') {
			$value = $this->skin_default;
		}
		
		return $value;
	}
	
	public function get_template() {
		$value = $this->get_post_meta($this->template_key);
		if ($value == '') {
			if ($this->is_image_gallery()) { $value = $this->template_default_image; }
		}
		
		return $value;
	}
	
	public function get_template_display() {
		$display = '';
		$template = $this->get_template();
		
		if ($template == MAXGALLERIA_LITE_TEMPLATE_IMAGE_TILES) { $display = __('Image Tiles', 'maxgalleria-lite'); }
		
		return $display;
	}
	
	public function get_thumb_caption_enabled() {
		$value = $this->get_post_meta($this->thumb_caption_enabled_key);
		if ($value == '') {
			$value = $this->thumb_caption_enabled_default;
		}
		
		return $value;
	}
	
	public function get_thumb_caption_position() {
		$value = $this->get_post_meta($this->thumb_caption_position_key);
		if ($value == '') {
			$value = $this->thumb_caption_position_default;
		}
		
		return $value;
	}
	
	public function get_thumb_click() {
		$value = $this->get_post_meta($this->thumb_click_key);
		if ($value == '') {
			$value = $this->thumb_click_default;
		}
		
		return $value;
	}
	
	public function get_thumb_click_new_window() {
		$value = $this->get_post_meta($this->thumb_click_new_window_key);
		if ($value == '') {
			$value = $this->thumb_click_new_window_default;
		}
		
		return $value;
	}
	
	public function get_thumb_columns() {
		$value = $this->get_post_meta($this->thumb_columns_key);
		if ($value == '') {
			$value = $this->thumb_columns_default;
		}
		
		return $value;
	}
	
	public function get_thumb_columns_class() {
		$value = '';
		
		$columns = $this->get_thumb_columns();
		if ($columns == 1) { $value = 'mg-onecol'; }
		if ($columns == 2) { $value = 'mg-twocol'; }
		if ($columns == 3) { $value = 'mg-threecol'; }
		if ($columns == 4) { $value = 'mg-fourcol'; }
		if ($columns == 5) { $value = 'mg-fivecol'; }
		if ($columns == 6) { $value = 'mg-sixcol'; }
		if ($columns == 7) { $value = 'mg-sevencol'; }
		if ($columns == 8) { $value = 'mg-eightcol'; }
		if ($columns == 9) { $value = 'mg-ninecol'; }
		if ($columns == 10) { $value = 'mg-tencol'; }
		
		return $value;
	}
	
	public function get_thumb_opacity_enabled() {
		$value = $this->get_post_meta($this->thumb_opacity_enabled_key);
		if ($value == '') {
			$value = $this->thumb_opacity_enabled_default;
		}
		
		return $value;
	}
	
	public function get_thumb_shape() {
		$value = $this->get_post_meta($this->thumb_shape_key);
		if ($value == '') {
			if ($this->is_image_gallery()) { $value = $this->thumb_shape_default_image; }
		}
		
		return $value;
	}
	
	public function get_type() {
		return $this->get_post_meta($this->type_key);
	}
	
	public function is_new_gallery() {
		// Use get_post_meta() instead of get_type() because get_type() will return
		// the default if it's an empty string, but we want to know if it's actually
		// an empty string to know if this is a new gallery or not.
		return ($this->get_post_meta($this->type_key) == '') ? true : false;
	}
	
	public function is_image_gallery() {
		return ($this->get_type() == 'image') ? true : false;
	}
	
	public function save_options() {
		if ($this->is_new_gallery()) {
			$this->add_update_post_meta($this->type_key);
		}
		else {
			$options = array();
			
			switch ($this->get_template()) {
				case MAXGALLERIA_LITE_TEMPLATE_IMAGE_TILES:
					$options = $this->get_template_options_image_tiles();
					break;
			}
			
			foreach ($options as $option) {
				if (isset($_POST[$this->reset_options_key]) && $_POST[$this->reset_options_key] == 'on') {
					// Don't reset the template
					if ($option != $this->template_key) {
						$this->delete_post_meta($option);
					}
				}
				else {
					$this->add_update_post_meta($option);
				}
			}
		}
	}
	
	private function get_template_options_image_tiles() {
		return array(
			$this->description_enabled_key,
			$this->description_position_key,
			$this->description_text_key,
			$this->lightbox_caption_enabled_key,
			$this->lightbox_caption_position_key,
			$this->lightbox_image_size_custom_height_key,
			$this->lightbox_image_size_custom_width_key,
			$this->lightbox_image_size_key,
			$this->skin_key,
			$this->template_key,
			$this->thumb_caption_enabled_key,
			$this->thumb_caption_position_key,
			$this->thumb_click_key,
			$this->thumb_click_new_window_key,
			$this->thumb_columns_key,
			$this->thumb_shape_key,
		);
	}
}
?>