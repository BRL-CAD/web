<?php
class MGAdmin {
	function __construct() {
		add_action('admin_menu', array($this, 'add_menu_pages'));
	}
	
	function add_menu_pages() {
		$parent_slug = 'edit.php?post_type=' . MAXGALLERIA_LITE_POST_TYPE;
		$page_title = __('MaxGalleria: NextGEN Importer', 'maxgalleria-lite');
		$sub_menu_title = __('NextGEN Importer', 'maxgalleria-lite');
		$capability = 'upload_files';
		$menu_slug = 'maxgalleria-nextgen-importer';
		$function = array($this, 'add_nextgen_importer_page');
		add_submenu_page($parent_slug, $page_title, $sub_menu_title, $capability, $menu_slug, $function);
		
		$parent_slug = 'edit.php?post_type=' . MAXGALLERIA_LITE_POST_TYPE;
		$page_title = __('MaxGalleria: Full Version', 'maxgalleria-lite');
		$sub_menu_title = __('Full Version', 'maxgalleria-lite');
		$capability = 'read';
		$menu_slug = 'maxgalleria-full-version';
		$function = array($this, 'add_full_version_page');
		add_submenu_page($parent_slug, $page_title, $sub_menu_title, $capability, $menu_slug, $function);
		
		$parent_slug = 'edit.php?post_type=' . MAXGALLERIA_LITE_POST_TYPE;
		$page_title = __('MaxGalleria: Support', 'maxgalleria-lite');
		$sub_menu_title = __('Support', 'maxgalleria-lite');
		$capability = 'read';
		$menu_slug = 'maxgalleria-support';
		$function = array($this, 'add_support_page');
		add_submenu_page($parent_slug, $page_title, $sub_menu_title, $capability, $menu_slug, $function);
	}

	function add_nextgen_importer_page() {
		require_once 'admin/nextgen-importer.php';
	}

	function add_full_version_page() {
		require_once 'admin/full-version.php';
	}
	
	function add_support_page() {
		require_once 'admin/support.php';
	}
}
?>