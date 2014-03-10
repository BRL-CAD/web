<?php
class MGNextGen {
	public $nonce_nextgen_importer = array(
		'action' => 'nextgen_importer',
		'name' => 'maxgalleria_nextgen_importer'
	);
	
	function __construct() {
		// Ajax call for importing a NextGEN gallery
		add_action('wp_ajax_import_nextgen_gallery', array($this, 'import_nextgen_gallery'));
		add_action('wp_ajax_nopriv_import_nextgen_gallery', array($this, 'import_nextgen_gallery'));
		
		// Ajax call for getting the import percent of a NextGEN gallery
		add_action('wp_ajax_get_nextgen_import_percent', array($this, 'get_nextgen_import_percent'));
		add_action('wp_ajax_nopriv_get_nextgen_import_percent', array($this, 'get_nextgen_import_percent'));
		
		// Ajax call for resetting the import percent and count of a NextGEN gallery
		add_action('wp_ajax_reset_nextgen_import', array($this, 'reset_nextgen_import'));
		add_action('wp_ajax_nopriv_reset_nextgen_import', array($this, 'reset_nextgen_import'));
	}

	function import_nextgen_gallery() {
		global $maxgalleria;
		$common = $maxgalleria->common;
		
		if (isset($_POST) && check_admin_referer($this->nonce_nextgen_importer['action'], $this->nonce_nextgen_importer['name'])) {
			$nextgen_import_count = 0;
			$maxgalleria_gallery = null;
			
			$nextgen_gallery_id = $_POST['nextgen_gallery_id'];
			$nextgen_gallery = $this->get_nextgen_gallery($nextgen_gallery_id);
			$nextgen_gallery_pics = $this->get_nextgen_gallery_pictures($nextgen_gallery_id);
			$nextgen_gallery_pics_count = $this->get_nextgen_gallery_picture_count($nextgen_gallery_id);
			
			switch ($_POST['maxgalleria_gallery_where']) {
				case 'existing':
					$maxgalleria_gallery = get_post($_POST['maxgalleria_gallery_id']);
					break;
				case 'new':
					// First create the gallery post itself
					$new_id = wp_insert_post(array('post_title' => stripslashes($_POST['maxgalleria_gallery_title']), 'post_type' => MAXGALLERIA_LITE_POST_TYPE));
					
					// Then save the gallery type
					$maxgallery = new MaxGallery($new_id);
					add_post_meta($new_id, $maxgallery->type_key, 'image', true);
					
					// And finally get the full gallery post back
					$maxgalleria_gallery = get_post($new_id);
					break;
			}
			
			if (isset($maxgalleria_gallery)) {
				// Turn number of galleries to process into chunks for progress bar
				$chunks = ceil(100 / $nextgen_gallery_pics_count) + 1;
				$chunk = 0;
				
				foreach ($nextgen_gallery_pics as $pic) {
					$url = trailingslashit(site_url()) . trailingslashit($nextgen_gallery->path) . $pic->filename;
					
					// Get the contents of the pic
					$response = wp_remote_get($url);
					$contents = wp_remote_retrieve_body($response);

					// Upload and get file data
					$upload = wp_upload_bits(basename($url), null, $contents);
					$guid = $upload['url'];
					$file = $upload['file'];
					$file_type = wp_check_filetype(basename($file), null);

					// Get menu order
					$menu_order = $common->get_next_menu_order($maxgalleria_gallery->ID);
					
					// Create attachment
					$attachment = array(
						'ID' => 0,
						'guid' => $upload['url'],
						'post_title' => $pic->alttext != '' ? $pic->alttext : $pic->image_slug,
						'post_excerpt' => $pic->description,
						'post_content' => $pic->description,
						'post_date' => '', // Ensures it gets today's date
						'post_parent' => $maxgalleria_gallery->ID,
						'post_mime_type' => $file_type['type'],
						'ancestors' => array(),
						'menu_order' => $menu_order
					);
					
					// Include image.php so we can call wp_generate_attachment_metadata()
					require_once(ABSPATH . 'wp-admin/includes/image.php');
					
					// Insert the attachment
					$attachment_id = wp_insert_attachment($attachment, $file, $maxgalleria_gallery->ID);
					$attachment_data = wp_generate_attachment_metadata($attachment_id, $file);
					wp_update_attachment_metadata($attachment_id, $attachment_data);
					
					// Save alt text in the post meta and increment counter
					update_post_meta($attachment_id, '_wp_attachment_image_alt', $pic->alttext);
					$nextgen_import_count++;
					
					// Increment chunks for progress bar
					$chunk++;
					update_option('maxgalleria_nextgen_import_percent', $chunk * $chunks);
				}
			}
			
			$gallery_edit_url = admin_url('post.php?post=' . $maxgalleria_gallery->ID . '&action=edit');
			$message = sprintf(__('%sSuccessfully imported %d of %d images from NextGEN into the "%s%s%s" gallery.%s', 'maxgalleria-lite'), '<h3>', $nextgen_import_count, $nextgen_gallery_pics_count, '<a href="' . $gallery_edit_url . '">', $maxgalleria_gallery->post_title, '</a>', '</h3>');
			echo $message;
			die();
		}
	}
	
	function get_nextgen_import_percent() {
		$import_percent = get_option('maxgalleria_nextgen_import_percent');
		$percentage = ($import_percent > 100) ? 100 : $import_percent;	
		
		echo $percentage;
		die();
	}

	function reset_nextgen_import() {
		update_option('maxgalleria_nextgen_import_count', 0);
		update_option('maxgalleria_nextgen_import_percent', 0);
		
		// No need to echo anything for a return
		die();
	}

	function get_nextgen_gallery($id) {
		global $wpdb;
		return $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $this->get_nextgen_gallery_table() . " WHERE gid = %d", $id));
	}

	function get_nextgen_galleries() {
		global $wpdb;
		return $wpdb->get_results("SELECT * FROM " . $this->get_nextgen_gallery_table());
	}

	function get_nextgen_gallery_picture_count($id) {
		global $wpdb;
		return $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM " . $this->get_nextgen_pictures_table() . " WHERE galleryid = %d", $id));
	}

	function get_nextgen_gallery_pictures($id) {
		global $wpdb;
		return $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $this->get_nextgen_pictures_table() . " WHERE galleryid = %d", $id));
	}

	function get_nextgen_gallery_table() {
		global $wpdb;
		return $wpdb->prefix . 'ngg_gallery';
	}

	function get_nextgen_pictures_table() {
		global $wpdb;
		return $wpdb->prefix . 'ngg_pictures';
	}

	function is_nextgen_installed() {
		$plugins = get_plugins();

		foreach ($plugins as $plugin_path => $plugin) {
			if ($plugin['Name'] == 'NextGEN Gallery' || $plugin['Name'] == 'NextGEN Gallery by Photocrati') {
				return true;
			}
		}
		
		return false;
	}
}
?>