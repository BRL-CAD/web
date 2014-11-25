<?php
global $post;
$maxgallery = new MaxGallery($post->ID);
?>

<script type="text/javascript">			
	jQuery(document).ready(function() {
		// Hides the meta box
		jQuery("#new-gallery").css("display", "none");
		
		// Creates the modal and sets its properties
		jQuery(".maxgalleria-meta").modal();
		jQuery("#simplemodal-container").css("background-color", "#ffffff");
		jQuery("#simplemodal-container").css("border-width", "2px");
		jQuery("#simplemodal-container").css("color", "#222222");
		jQuery("#simplemodal-container").css("width", "400px");
		jQuery("#simplemodal-container").css("height", "240px");
		
		jQuery("#simplemodal-container a.simplemodal-close").click(function() {
			jQuery.modal.close();
			window.location = "<?php echo admin_url() ?>edit.php?post_type=<?php echo MAXGALLERIA_LITE_POST_TYPE ?>";
		});
		
		jQuery("#<?php echo $maxgallery->type_key ?>_image_icon").click(function() {
			jQuery("#<?php echo $maxgallery->type_key ?>_image_icon").addClass("selected");
			jQuery("#<?php echo $maxgallery->type_key ?>_video_icon").removeClass("selected");
			jQuery("#<?php echo $maxgallery->type_key ?>").val("image");
			submitForm();
		});
	});
	
	function submitForm() {
		var form_data = jQuery("#post").serialize();
		form_data += "&<?php echo $maxgallery->type_key ?>=" + jQuery("#<?php echo $maxgallery->type_key ?>").val();
		form_data += "&action=save_new_gallery_type";
		
		jQuery.modal.close();
		
		jQuery.ajax({
			type: "POST",
			url: "<?php echo admin_url('admin-ajax.php') ?>",
			data: form_data,
			success: function(post_id) {
				window.location = "<?php echo admin_url() ?>post.php?post=" + post_id + "&action=edit";
			}
		});
	}
</script>

<div class="maxgalleria-meta" style="display: none;">
	<div class="gallery-type">
		<div align="center">
			<p><?php _e('What type of gallery do you want to create?', 'maxgalleria-lite') ?></p>
			
			<table>
				<tr>
					<td>
						<img class="image" id="<?php echo $maxgallery->type_key ?>_image_icon" src="<?php echo MAXGALLERIA_LITE_PLUGIN_URL ?>/images/image-80.png" alt="<?php _e('Image', 'maxgalleria-lite') ?>" title="<?php _e('Image', 'maxgalleria-lite') ?>" />
						<br />
						<label><?php _e('Image', 'maxgalleria-lite') ?></label>
					</td>
					<td>
						<img class="video" id="<?php echo $maxgallery->type_key ?>_video_icon" src="<?php echo MAXGALLERIA_LITE_PLUGIN_URL ?>/images/video-80.png" alt="<?php _e('Video', 'maxgalleria-lite') ?>" title="<?php _e('Video', 'maxgalleria-lite') ?>" />
						<br />
						<label><?php _e('Video *', 'maxgalleria-lite') ?></label>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="left">
						<p class="asterisk"><?php printf(__('* Video galleries available in the %sfull version%s', 'maxgalleria-lite'), '<a class="asterisk" href="' . admin_url() . 'edit.php?post_type=' . MAXGALLERIA_LITE_POST_TYPE . '&page=maxgalleria-full-version">', '</a>') ?></p>
					</td>
				</tr>
			</table>
			
			<input type="hidden" id="<?php echo $maxgallery->type_key ?>" name="<?php echo $maxgallery->type_key ?>" value="image" />
		</div>
	</div>
</div>
