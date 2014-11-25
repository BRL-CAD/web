<?php
require('../../../../wp-load.php');

$args = array(
	'post_type' => MAXGALLERIA_LITE_POST_TYPE,
	'status' => 'publish',
	'numberposts' => -1, // All of them
	'orderby' => 'title',
	'order' => 'ASC'
);

$galleries = get_posts($args);
?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title><?php _e('Insert Image Gallery', 'maxgalleria-lite') ?></title>
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo MAXGALLERIA_LITE_PLUGIN_URL ?>/maxgalleria.css" />
	<script type="text/javascript" src="<?php echo includes_url() ?>js/jquery/jquery.js"></script>
	<script type="text/javascript" src="<?php echo includes_url() ?>js/tinymce/tiny_mce_popup.js"></script>
	<script type="text/javascript">
		tinyMCEPopup.onInit.add(function(editor) {
			insert = jQuery("#insert-button").click(function() {
				var shortcode = '';
				var gallery_id = jQuery("#gallery-select").val();
				
				if (gallery_id != '') {
					var shortcode = '[maxgallery id="' + gallery_id + '"]';
				}
				
				if (window.tinyMCE) {
					window.tinyMCE.execInstanceCommand("content", "mceInsertContent", false, shortcode);
					tinyMCEPopup.editor.execCommand("mceRepaint");
					tinyMCEPopup.close();
				}
			}),
			
			cancel = jQuery("#cancel-button").click(function () {
				tinyMCEPopup.close();
			});
		});
	</script>
</head>

<body>

<div class="maxgalleria-meta tinymce">
	<p><?php _e('Select an image gallery from the list below. The shortcode will be inserted into the content editor at the location of the cursor.', 'maxgalleria-lite') ?></p>
	
	<div align="center">
		<select id="gallery-select">
			<option value=""><?php _e('-- Select Gallery--', 'maxgalleria-lite') ?></option>
			<optgroup label="<?php _e('Image Galleries', 'maxgalleria-lite') ?>">
			<?php foreach ($galleries as $gallery) { ?>
				<?php
				$maxgallery = new MaxGallery($gallery->ID);
				if ($maxgallery->is_image_gallery()) {
					$args = array('post_parent' => $gallery->ID, 'post_type' => 'attachment', 'numberposts' => -1);
					$attachments = get_posts($args);
					
					$number = '';
					if (count($attachments) == 0) { $number = __(' (0 images)', 'maxgalleria-lite'); }
					if (count($attachments) == 1) { $number =  __(' (1 image)', 'maxgalleria-lite'); }
					if (count($attachments) > 1) { $number = sprintf(__(' (%d images)', 'maxgalleria-lite'), count($attachments)); }
					
					echo '<option value="' . $gallery->ID . '">' . $gallery->post_title . $number . '</option>';
				}
				?>
			<?php } ?>
			</optgroup>
		</select>
				
		<div class="actions">
			<div class="insert">
				<input type="button" class="btn btn-primary" id="insert-button" value="<?php _e('Insert Gallery', 'maxgalleria-lite') ?>" />
			</div>
			<div class="cancel">
				<input type="button" class="btn" id="cancel-button" value="<?php _e('Cancel', 'maxgalleria-lite') ?>" />
			</div>
		</div>
	</div>
</div>

</body>

</html>
