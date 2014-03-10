<?php
class MGImageGallery {
	public $nonce_image_edit = array(
		'action' => 'image_edit',
		'name' => 'maxgalleria_image_edit'
	);

	public $nonce_image_edit_bulk = array(
		'action' => 'image_edit_bulk',
		'name' => 'maxgalleria_image_edit_bulk'
	);
	
	public $nonce_image_include_single = array(
		'action' => 'image_include_single',
		'name' => 'maxgalleria_image_include_single'
	);

	public $nonce_image_include_bulk = array(
		'action' => 'image_include_bulk',
		'name' => 'maxgalleria_image_include_bulk'
	);

	public $nonce_image_exclude_single = array(
		'action' => 'image_exclude_single',
		'name' => 'maxgalleria_image_exclude_single'
	);

	public $nonce_image_exclude_bulk = array(
		'action' => 'image_exclude_bulk',
		'name' => 'maxgalleria_image_exclude_bulk'
	);

	public $nonce_image_remove_single = array(
		'action' => 'image_remove_single',
		'name' => 'maxgalleria_image_remove_single'
	);

	public $nonce_image_remove_bulk = array(
		'action' => 'image_remove_bulk',
		'name' => 'maxgalleria_image_remove_bulk'
	);

	public $nonce_image_reorder = array(
		'action' => 'image_reorder',
		'name' => 'maxgalleria_image_reorder'
	);
	
	function __construct() {
		$this->setup_hooks();
		
		// Ajax call to include a single image in a gallery
		add_action('wp_ajax_include_single_image_in_gallery', array($this, 'include_single_image_in_gallery'));
		add_action('wp_ajax_nopriv_include_single_image_in_gallery', array($this, 'include_single_image_in_gallery'));

		// Ajax call to include bulk images in a gallery
		add_action('wp_ajax_include_bulk_images_in_gallery', array($this, 'include_bulk_images_in_gallery'));
		add_action('wp_ajax_nopriv_include_bulk_images_in_gallery', array($this, 'include_bulk_images_in_gallery'));

		// Ajax call to exclude a single image from a gallery
		add_action('wp_ajax_exclude_single_image_from_gallery', array($this, 'exclude_single_image_from_gallery'));
		add_action('wp_ajax_nopriv_exclude_single_image_from_gallery', array($this, 'exclude_single_image_from_gallery'));

		// Ajax call to exclude bulk images from a gallery
		add_action('wp_ajax_exclude_bulk_images_from_gallery', array($this, 'exclude_bulk_images_from_gallery'));
		add_action('wp_ajax_nopriv_exclude_bulk_images_from_gallery', array($this, 'exclude_bulk_images_from_gallery'));

		// Ajax call to remove a single image from a gallery
		add_action('wp_ajax_remove_single_image_from_gallery', array($this, 'remove_single_image_from_gallery'));
		add_action('wp_ajax_nopriv_remove_single_image_from_gallery', array($this, 'remove_single_image_from_gallery'));
		
		// Ajax call to remove bulk images from a gallery
		add_action('wp_ajax_remove_bulk_images_from_gallery', array($this, 'remove_bulk_images_from_gallery'));
		add_action('wp_ajax_nopriv_remove_bulk_images_from_gallery', array($this, 'remove_bulk_images_from_gallery'));

		// Ajax call to reorder images
		add_action('wp_ajax_reorder_images', array($this, 'reorder_images'));
		add_action('wp_ajax_nopriv_reorder_images', array($this, 'reorder_images'));
	}

	function setup_hooks() {
		add_action('admin_head', array($this, 'replace_save_all_changes_button'));
		
		// IMPORTANT: This filter is treated a little differently because of how it needs
		// to handle new image uploads. Therefore, it sits away from the other filters
		// that get created with media_library_in_context().
		add_filter('attachment_fields_to_edit', array($this, 'do_attachment_fields_to_edit'), 50, 2);

		// Only add these actions and filters for our own context
		if ($this->media_library_in_context('maxgalleria')) {
			add_action('admin_print_styles-media-upload-popup', array($this, 'enqueue_styles_media_upload_popup'), 50);
			add_filter('post_mime_types', array($this, 'set_post_mime_types'), 50, 1);
			add_filter('upload_mimes', array($this, 'set_upload_mimes'), 50, 1);
			add_filter('media_upload_tabs', array($this, 'set_media_upload_tabs'), 50, 1);
			add_filter('media_upload_mime_type_links', array($this, 'set_media_upload_mime_type_links'), 50, 1);
			add_filter('media_upload_form_url', array($this, 'set_media_upload_form_url'), 50, 2);
		}
	}
	
	function replace_save_all_changes_button() {
		// This is used to hide and replace the "Save all changes" button with
		// our own "Close" button. The "Save all changes" button is a general
		// source of confusion, especially in our streamlined workflow, so having
		// the "Close" button greatly enhances the workflow.
		
		$output = '<script type="text/javascript">';
		$output .= 'jQuery(document).ready(function() {';
		$output .= '	jQuery("#media-upload").append("<div style=\'margin-left: 5px; padding-bottom: 15px;\' class=\'maxgalleria-meta\'><a href=\'#\' style=\'text-decoration: none;\' class=\'btn btn-primary\' id=\'gallery_close_thickbox_button\'>' . __('Close', 'maxgalleria-lite') . '</a></div>");';
		$output .= '	jQuery("#gallery_close_thickbox_button").click(function() {';
		$output .= '		parent.eval("reloadPage()");';
		$output .= '		return false;';
		$output .= '	});';
		$output .= '});';
		$output .= '</script>';
		$output .= '<style type="text/css">';
		$output .= '	#gallery-settings { display: none !important; }';
		$output .= '	#media-upload p.ml-submit { display: none !important; }';
		$output .= '</style>';
		
		echo $output;
	}
	
	function media_library_in_context($context) {
		if (isset($_REQUEST['context']) && $_REQUEST['context'] == $context) {
			return true;
		} elseif (isset($_POST['attachments']) && is_array($_POST['attachments'])) {
			// Check for context in attachment objects
			$image_data = current($_POST['attachments']);
			if (isset($image_data['context']) && $image_data['context'] == $context ) {
				return true;
			}
		}
		
		return false;
	}

	function enqueue_styles_media_upload_popup() {
		wp_enqueue_style('maxgalleria-css', MAXGALLERIA_LITE_PLUGIN_URL . '/maxgalleria.css');
	}

	function set_post_mime_types($mime_types) {
		// Remove the audio type
		
		unset($mime_types['audio']);
		return $mime_types;
	}

	function set_upload_mimes($mime_types) {
		// Only allow image file type uploads. The complete list allowed by WordPress is
		// located in the get_allowed_mime_types() function in wp-includes/functions.php.
		
		$mime_types = array(
			'jpg|jpeg|jpe' => 'image/jpeg',
			'gif' => 'image/gif',
			'png' => 'image/png',
			'bmp' => 'image/bmp',
			'tif/tiff' => 'image/tiff'
		);
		
		return $mime_types;
	}
	
	function set_media_upload_tabs($tabs) {
		// Only the "From Computer" tab should be shown.

		unset($tabs['type_url']);	// From URL tab
		unset($tabs['library']);	// Media Library tab
		unset($tabs['gallery']);	// Gallery tab
		unset($tabs['nextgen']);	// NextGEN tab
		
		return $tabs;
	}

	function set_media_upload_mime_type_links($type_links) {
		// Filters the "All Types" from the type links and adds a hidden field
		// to ensure the filter is retained on a search or filter request
		
		array_shift($type_links);

		// Add hidden field
		if (count($type_links) > 0) {
			$type_links[0] = '<input type="hidden" name="filter" value="maxgallery" />';
		}
		
		return $type_links;
	}

	function set_media_upload_form_url($form_action_url, $type) {
		// Ensure we keep the right attachment fields by adding our filter query arg
		return add_query_arg('filter', 'maxgallery', $form_action_url);
	}

	function do_attachment_fields_to_edit($form_fields, $attachment) {
		global $maxgalleria;
		$common = $maxgalleria->common;
		
		$context = isset($_REQUEST['context']) ? $_REQUEST['context'] : '';
		$post_id = isset($_REQUEST['post_id']) ? $_REQUEST['post_id'] : 0;
		$attachment_id = (is_object($attachment) && $attachment->ID) ? $attachment->ID : 0;
		
		$send = '';

		// This block is to handle the uploading of new images, which are attached
		// to the gallery by adding files from the "From Computer" tab using the
		// drag-and-drop area or the browser uploader. The async-upload.php file
		// is what WordPress uses for this, which won't have the context as part of
		// the URL request.
		if ($context == '' && $post_id == 0) {		
			if (substr($attachment->post_mime_type, 0, 5) == 'image') {
				$ancestors = get_post_ancestors($attachment_id);
				$root = count($ancestors) > 0 ? count($ancestors) - 1 : 0;
				$parent = $ancestors[$root];
				
				if ($parent == $attachment->post_parent) {
					$post_parent = get_post($parent);

					if ($post_parent->post_type == MAXGALLERIA_LITE_POST_TYPE) {
						if ($maxgalleria->admin_page_is_media_edit()) {
							// We know we're on the media edit page, so don't do anything
						}
						else {					
							// Get menu order for the image
							$menu_order = $common->get_next_menu_order($attachment->post_parent);
							
							// Save the attachment; we only have the title at this point, so we initially
							// populate post_title, post_excerpt, and post_content with it as seed data.
							$temp = array();
							$temp['ID'] = $attachment->ID;
							$temp['post_title'] = $attachment->post_title;
							$temp['post_excerpt'] = $attachment->post_title;
							$temp['post_content'] = $attachment->post_title;
							$temp['menu_order'] = $menu_order;
							wp_update_post($temp);
							
							// Same here, give the alt image post meta the title as seed data
							update_post_meta($attachment->ID, '_wp_attachment_image_alt', $attachment->post_title);
							
							// Replace URL field with a hidden field
							$form_fields['url'] = array('input' => 'hidden', 'value' => wp_get_attachment_url($attachment->ID));

							// Remove the image Alignment and Size fields
							unset($form_fields['align']);
							unset($form_fields['image-size']);
							
							// Add our own context field
							$form_fields['context'] = array('input' => 'hidden', 'value' => 'maxgalleria');
							?>
							
							<script type="text/javascript">
								// Needed to show the "Added" label when new images are uploaded
								jQuery(document).ready(function() {
									jQuery(".filename.new:not(:has('div.maxgalleria-meta'))").each(function() {
										jQuery(this).append('<div class="maxgalleria-meta upload-label"><span class="label label-success"><?php _e('Added', 'maxgalleria-lite') ?></span></div>');
										jQuery(this).append('<div class="clear"></div>');
									});
								});
							</script>
							
							<?php
							// The send value can't be empty otherwise WordPress will display the default, which is
							// the "Insert Into Gallery" button and "Delete" link, so we set it to an empty span element.
							$send = '</span>&nbsp;</span>';
							unset($form_fields['button']);
						}
					}
				}
			}
		}
		
		if ($send != '') {
			$form_fields['buttons'] = array('tr' => "\t\t<tr class='submit'><td></td><td class='savesend'>$send</td></tr>\n");
		}
		
		return $form_fields;
	}

	function include_single_image_in_gallery() {
		if (isset($_POST) && check_admin_referer($this->nonce_image_include_single['action'], $this->nonce_image_include_single['name'])) {
			$message = '';

			if (isset($_POST['id'])) {			
				$image_post = get_post($_POST['id']);
				if (isset($image_post)) {
					delete_post_meta($image_post->ID, 'maxgallery_attachment_image_exclude', true);
					$message = __('Included the image in this gallery.', 'maxgalleria-lite');
				}
			}
			
			echo $message;
			die();
		}
	}

	function include_bulk_images_in_gallery() {
		if (isset($_POST) && check_admin_referer($this->nonce_image_include_bulk['action'], $this->nonce_image_include_bulk['name'])) {
			$message = '';

			if (isset($_POST['media-id']) && isset($_POST['bulk-action-select'])) {
				if ($_POST['bulk-action-select'] == 'include') {
					$count = 0;
					
					foreach ($_POST['media-id'] as $id) {
						$image_post = get_post($id);
						if (isset($image_post)) {
							delete_post_meta($image_post->ID, 'maxgallery_attachment_image_exclude', true);
							$count++;
						}
					}
					
					if ($count == 1) {
						$message = __('Included 1 image in this gallery.', 'maxgalleria-lite');
					}
					
					if ($count > 1) {
						$message = sprintf(__('Included %d images in this gallery.', 'maxgalleria-lite'), $count);
					}
				}
			}
			
			echo $message;
			die();
		}
	}

	function exclude_single_image_from_gallery() {
		if (isset($_POST) && check_admin_referer($this->nonce_image_exclude_single['action'], $this->nonce_image_exclude_single['name'])) {
			$message = '';

			if (isset($_POST['id'])) {			
				$image_post = get_post($_POST['id']);
				if (isset($image_post)) {
					update_post_meta($image_post->ID, 'maxgallery_attachment_image_exclude', true);
					$message = __('Excluded the image from this gallery.', 'maxgalleria-lite');
				}
			}
			
			echo $message;
			die();
		}
	}

	function exclude_bulk_images_from_gallery() {
		if (isset($_POST) && check_admin_referer($this->nonce_image_exclude_bulk['action'], $this->nonce_image_exclude_bulk['name'])) {
			$message = '';

			if (isset($_POST['media-id']) && isset($_POST['bulk-action-select'])) {
				if ($_POST['bulk-action-select'] == 'exclude') {
					$count = 0;
					
					foreach ($_POST['media-id'] as $id) {
						$image_post = get_post($id);
						if (isset($image_post)) {
							update_post_meta($image_post->ID, 'maxgallery_attachment_image_exclude', true);
							$count++;
						}
					}
					
					if ($count == 1) {
						$message = __('Excluded 1 image from this gallery.', 'maxgalleria-lite');
					}
					
					if ($count > 1) {
						$message = sprintf(__('Excluded %d images from this gallery.', 'maxgalleria-lite'), $count);
					}
				}
			}
			
			echo $message;
			die();
		}
	}

	function remove_single_image_from_gallery() {
		if (isset($_POST) && check_admin_referer($this->nonce_image_remove_single['action'], $this->nonce_image_remove_single['name'])) {
			$message = '';

			if (isset($_POST['id'])) {			
				$image_post = get_post($_POST['id']);
				if (isset($image_post)) {
					$temp = array();
					$temp['ID'] = $image_post->ID;
					$temp['post_parent'] = null;
					
					wp_update_post($temp);
					$message = __('Removed the image from this gallery. To delete it permanently, use the Media Library.', 'maxgalleria-lite');
				}
			}
			
			echo $message;
			die();
		}
	}

	function remove_bulk_images_from_gallery() {
		if (isset($_POST) && check_admin_referer($this->nonce_image_remove_bulk['action'], $this->nonce_image_remove_bulk['name'])) {
			$message = '';

			if (isset($_POST['media-id']) && isset($_POST['bulk-action-select'])) {
				if ($_POST['bulk-action-select'] == 'remove') {
					$count = 0;
					
					foreach ($_POST['media-id'] as $id) {
						$image_post = get_post($id);
						if (isset($image_post)) {
							$temp = array();
							$temp['ID'] = $image_post->ID;
							$temp['post_parent'] = null;
							
							wp_update_post($temp);
							$count++;
						}
					}
					
					if ($count == 1) {
						$message = __('Removed 1 image from this gallery. To delete it permanently, use the Media Library.', 'maxgalleria-lite');
					}
					
					if ($count > 1) {
						$message = sprintf(__('Removed %d images from this gallery. To delete them permanently, use the Media Library.', 'maxgalleria-lite'), $count);
					}
				}
			}
			
			echo $message;
			die();
		}
	}

	function reorder_images() {
		if (isset($_POST) && check_admin_referer($this->nonce_image_reorder['action'], $this->nonce_image_reorder['name'])) {
			$message = '';

			if (isset($_POST['media-order']) && isset($_POST['media-order-id'])) {		
				for ($i = 0; $i < count($_POST['media-order']); $i++) {
					$order = $_POST['media-order'][$i];
					$image_id = $_POST['media-order-id'][$i];
					
					$image_post = get_post($image_id);
					if (isset($image_post)) {
						$temp = array();
						$temp['ID'] = $image_post->ID;
						$temp['menu_order'] = $order;
						
						wp_update_post($temp);
					}
				}
			}
			
			echo $message;
			die();
		}
	}

	function show_meta_box_image_gallery_advanced($post) {
		require_once 'meta/image-gallery-advanced.php';
	}
	
	function show_meta_box_image_gallery_description($post) {
		require_once 'meta/image-gallery-description.php';
	}
	
	function show_meta_box_image_gallery_images($post) {
		require_once 'meta/image-gallery-images.php';
	}
	
	function show_meta_box_image_gallery_layout($post) {
		require_once 'meta/image-gallery-layout.php';
	}
	
	function show_meta_box_image_gallery_lightbox($post) {
		require_once 'meta/image-gallery-lightbox.php';
	}
	
	function show_meta_box_image_gallery_shortcodes($post) {
		require_once 'meta/image-gallery-shortcodes.php';
	}
	
	function show_meta_box_image_gallery_thumbnails($post) {
		require_once 'meta/image-gallery-thumbnails.php';
	}
	
	function get_image_size_display($attachment) {
		$size = '';
		
		$meta = wp_get_attachment_metadata($attachment->ID);
		if (is_array($meta) && array_key_exists('width', $meta) && array_key_exists('height', $meta)) {
			$size = "{$meta['width']} &times; {$meta['height']}";
		}
		
		return $size;
	}
	
	function get_lightbox_image($maxgallery, $attachment) {
		$quality = 100;
		$lightbox_image = null;
		
		if ($maxgallery->get_lightbox_image_size() == 'custom') {
			$lightbox_image_size_custom_width = $maxgallery->get_lightbox_image_size_custom_width();
			$lightbox_image_size_custom_height = $maxgallery->get_lightbox_image_size_custom_height();
			$lightbox_image = $this->resize_image($attachment->ID, '', $lightbox_image_size_custom_width, $lightbox_image_size_custom_height, true, $quality);
		}
		else {
			$meta = wp_get_attachment_metadata($attachment->ID);
			if (is_array($meta) && array_key_exists('width', $meta) && array_key_exists('height', $meta)) {
				$lightbox_image = array('url' => $attachment->guid, 'width' => $meta['width'], 'height' => $meta['height']);
			}
			else {
				$lightbox_image = array('url' => $attachment->guid, 'width' => '', 'height' => '');
			}
		}
		
		return $lightbox_image;
	}
	
	function get_thumb_image($maxgallery, $attachment) {
		$quality = 100;
		$thumb_size = $this->get_thumb_size($maxgallery);
		$thumb_image = $this->resize_image($attachment->ID, '', $thumb_size['width'], $thumb_size['height'], true, $quality);
		return $thumb_image;
	}
	
	function get_thumb_size($maxgallery) {
		$thumb_size = null;
		
		$thumb_shape = $maxgallery->get_thumb_shape();
		$columns = $maxgallery->get_thumb_columns();

		switch ($thumb_shape) {
			case MAXGALLERIA_LITE_THUMB_SHAPE_LANDSCAPE:
				if ($columns == 1) { $thumb_size = array('width' => '700', 'height' => '466'); }
				if ($columns == 2) { $thumb_size = array('width' => '550', 'height' => '366'); }
				if ($columns == 3) { $thumb_size = array('width' => '400', 'height' => '266'); }
				if ($columns == 4) { $thumb_size = array('width' => '250', 'height' => '166'); }
				if ($columns == 5) { $thumb_size = array('width' => '200', 'height' => '133'); }
				if ($columns == 6) { $thumb_size = array('width' => '180', 'height' => '120'); }
				if ($columns == 7) { $thumb_size = array('width' => '150', 'height' => '100'); }
				if ($columns == 8) { $thumb_size = array('width' => '130', 'height' => '86'); }
				if ($columns == 9) { $thumb_size = array('width' => '115', 'height' => '76'); }
				if ($columns == 10) { $thumb_size = array('width' => '100', 'height' => '66'); }
				break;
			case MAXGALLERIA_LITE_THUMB_SHAPE_PORTRAIT:
				if ($columns == 1) { $thumb_size = array('width' => '700', 'height' => '1050'); }
				if ($columns == 2) { $thumb_size = array('width' => '550', 'height' => '825'); }
				if ($columns == 3) { $thumb_size = array('width' => '400', 'height' => '600'); }
				if ($columns == 4) { $thumb_size = array('width' => '250', 'height' => '375'); }
				if ($columns == 5) { $thumb_size = array('width' => '200', 'height' => '300'); }
				if ($columns == 6) { $thumb_size = array('width' => '180', 'height' => '270'); }
				if ($columns == 7) { $thumb_size = array('width' => '150', 'height' => '225'); }
				if ($columns == 8) { $thumb_size = array('width' => '130', 'height' => '195'); }
				if ($columns == 9) { $thumb_size = array('width' => '115', 'height' => '172'); }
				if ($columns == 10) { $thumb_size = array('width' => '100', 'height' => '150'); }
				break;
			default:
				// Square
				if ($columns == 1) { $thumb_size = array('width' => '700', 'height' => '700'); }
				if ($columns == 2) { $thumb_size = array('width' => '550', 'height' => '550'); }
				if ($columns == 3) { $thumb_size = array('width' => '400', 'height' => '400'); }
				if ($columns == 4) { $thumb_size = array('width' => '250', 'height' => '250'); }
				if ($columns == 5) { $thumb_size = array('width' => '200', 'height' => '200'); }
				if ($columns == 6) { $thumb_size = array('width' => '180', 'height' => '180'); }
				if ($columns == 7) { $thumb_size = array('width' => '150', 'height' => '150'); }
				if ($columns == 8) { $thumb_size = array('width' => '130', 'height' => '130'); }
				if ($columns == 9) { $thumb_size = array('width' => '115', 'height' => '115'); }
				if ($columns == 10) { $thumb_size = array('width' => '100', 'height' => '100'); }
				break;
		}
		
		return $thumb_size;
	}

	/*
	 * This function taken directly from http://core.trac.wordpress.org/ticket/15311.
	 * Everything is verbatim, aside from renaming the function and fixing line 100
	 * where the image_resize() function is called (it needed nulls for a couple optional
	 * parameters). It's possible this function will get added to a future release of
	 * WordPress, so we'll need to keep an eye out for it.
	 *
	 * Resize images dynamically using wp built in functions
	 * Victor Teixeira
	 *
	 * php 5.2+
	 *
	 * Exemple use:
	 * 
	 * <?php 
	 * $thumb = get_post_thumbnail_id(); 
	 * $image = vt_resize( $thumb,'' , 140, 110, true, 70 );
	 * ?>
	 * <img src="<?php echo $image[url]; ?>" width="<?php echo $image[width]; ?>" height="<?php echo $image[height]; ?>" />
	 *
	 * @param int $attach_id
	 * @param string $img_url
	 * @param int $width
	 * @param int $height
	 * @param bool $crop
	 * @param int $jpeg_quality
	 * @return array
	 */
	function resize_image( $attach_id = null, $img_url = null, $width, $height, $crop = false, $jpeg_quality = 90 ) {
		// this is an attachment, so we have the ID
		if ( $attach_id ) {
		
			$image_src = wp_get_attachment_image_src( $attach_id, 'full' );
			$file_path = get_attached_file( $attach_id );
		
		// this is not an attachment, let's use the image url
		} else if ( $img_url ) {
			
			$file_path = parse_url( $img_url );
			$file_path = ltrim( $file_path['path'], '/' );
			//$file_path = rtrim( ABSPATH, '/' ).$file_path['path'];
			
			$orig_size = getimagesize( $file_path );
			
			$image_src[0] = $img_url;
			$image_src[1] = $orig_size[0];
			$image_src[2] = $orig_size[1];
		}
		
		$file_info = pathinfo( $file_path );
		$extension = '.'. $file_info['extension'];

		// the image path without the extension
		$no_ext_path = $file_info['dirname'].'/'.$file_info['filename'];

		$cropped_img_path = $no_ext_path.'-'.$width.'x'.$height.$extension;

		// checking if the file size is larger than the target size
		// if it is smaller or the same size, stop right here and return
		if ( $image_src[1] > $width || $image_src[2] > $height ) {

			// the file is larger, check if the resized version already exists (for crop = true but will also work for crop = false if the sizes match)
			if ( file_exists( $cropped_img_path ) ) {

				$cropped_img_url = str_replace( basename( $image_src[0] ), basename( $cropped_img_path ), $image_src[0] );
				
				$vt_image = array (
					'url' => $cropped_img_url,
					'width' => $width,
					'height' => $height
				);
				
				return $vt_image;
			}

			// crop = false
			if ( $crop == false ) {
			
				// calculate the size proportionaly
				$proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
				$resized_img_path = $no_ext_path.'-'.$proportional_size[0].'x'.$proportional_size[1].$extension;			

				// checking if the file already exists
				if ( file_exists( $resized_img_path ) ) {
				
					$resized_img_url = str_replace( basename( $image_src[0] ), basename( $resized_img_path ), $image_src[0] );

					$vt_image = array (
						'url' => $resized_img_url,
						'width' => $proportional_size[0],
						'height' => $proportional_size[1]
					);
					
					return $vt_image;
				}
			}

			// no cached files - let's finally resize it
			//$new_img_path = image_resize( $file_path, $width, $height, $crop, $jpeg_quality );
			$new_img_path = image_resize( $file_path, $width, $height, $crop, null, null, $jpeg_quality );
			$new_img_size = getimagesize( $new_img_path );
			$new_img = str_replace( basename( $image_src[0] ), basename( $new_img_path ), $image_src[0] );

			// resized output
			$vt_image = array (
				'url' => $new_img,
				'width' => $new_img_size[0],
				'height' => $new_img_size[1]
			);
			
			return $vt_image;
		}

		// default output - without resizing
		$vt_image = array (
			'url' => $image_src[0],
			'width' => $image_src[1],
			'height' => $image_src[2]
		);
		
		return $vt_image;
	}
}
?>