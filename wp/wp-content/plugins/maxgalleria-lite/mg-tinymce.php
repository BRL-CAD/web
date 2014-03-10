<?php
class MGTinyMce {
	function __construct() {
		add_action('init', array($this, 'setup_tinymce'));
	}
	
	function setup_tinymce() {
		if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
			return;
		}
		
		// Add only in rich editor mode (the Visual tab)
		if (get_user_option('rich_editing') == 'true') {
			add_filter('mce_external_plugins', array($this, 'add_tinymce_plugin'));
			add_filter('mce_buttons', array($this, 'add_tinymce_button'));
		}
	}

	function add_tinymce_plugin($plugin_array) {
		$plugin_array['MaxGalleria'] = MAXGALLERIA_LITE_PLUGIN_URL . '/tinymce/plugin.js';
		return $plugin_array;
	}

	function add_tinymce_button($buttons) {
		array_push($buttons, '|', 'MaxGalleria');
		return $buttons;
	}
}
?>