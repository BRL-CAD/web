<?php
$maxgallery = new MaxGallery($post->ID);

$caption_positions = array(
	__('Below Image', 'maxgalleria-lite') => 'below',
	__('Bottom of Image', 'maxgalleria-lite') => 'bottom'
);

$lightbox_sizes = array(
	__('Full', 'maxgalleria-lite') => 'full',
	__('Custom', 'maxgalleria-lite') => 'custom'
);
?>

<script type="text/javascript">		
	jQuery(document).ready(function() {
		jQuery(".maxgalleria-meta .accordion.lightbox").accordion({ collapsible: true, active: false, heightStyle: "auto" });
		
		enableDisableLightboxCustomSize();
		
		jQuery("#<?php echo $maxgallery->lightbox_image_size_key ?>").change(function() {
			enableDisableLightboxCustomSize();
		});
	});
	
	function enableDisableLightboxCustomSize() {
		image_size = jQuery("#<?php echo $maxgallery->lightbox_image_size_key ?>").val();
		
		if (image_size == "full") {
			jQuery("#<?php echo $maxgallery->lightbox_image_size_custom_width_key ?>").attr("disabled", "disabled");
			jQuery("#<?php echo $maxgallery->lightbox_image_size_custom_width_key ?>").attr("readonly", "readonly");
			jQuery("#<?php echo $maxgallery->lightbox_image_size_custom_height_key ?>").attr("disabled", "disabled");
			jQuery("#<?php echo $maxgallery->lightbox_image_size_custom_height_key ?>").attr("readonly", "readonly");
		}
		
		if (image_size == "custom") {
			jQuery("#<?php echo $maxgallery->lightbox_image_size_custom_width_key ?>").removeAttr("disabled");
			jQuery("#<?php echo $maxgallery->lightbox_image_size_custom_width_key ?>").removeAttr("readonly");
			jQuery("#<?php echo $maxgallery->lightbox_image_size_custom_height_key ?>").removeAttr("disabled");
			jQuery("#<?php echo $maxgallery->lightbox_image_size_custom_height_key ?>").removeAttr("readonly");
		}
	}
</script>

<div class="maxgalleria-meta">
	<div style="padding-bottom: 10px;"><?php _e('These settings apply only if the thumbnail click option is set to open a lightbox image.', 'maxgalleria-lite') ?></div>
	
	<div class="accordion lightbox">	
		<h4><?php _e('Captions', 'maxgalleria-lite') ?></h4>
		<div>
			<table>
				<tr>
					<td width="60">
						<label for="<?php echo $maxgallery->lightbox_caption_enabled_key ?>"><?php _e('Enabled', 'maxgalleria-lite') ?></label>
					</td>
					<td>
						<input type="checkbox" id="<?php echo $maxgallery->lightbox_caption_enabled_key ?>" name="<?php echo $maxgallery->lightbox_caption_enabled_key ?>" <?php echo (($maxgallery->get_lightbox_caption_enabled() == 'on') ? 'checked' : '') ?> />
					</td>
				</tr>
				<tr>
					<td width="60">
						<?php _e('Position', 'maxgalleria-lite') ?>
					</td>
					<td>
						<select id="<?php echo $maxgallery->lightbox_caption_position_key ?>" name="<?php echo $maxgallery->lightbox_caption_position_key ?>">
						<?php foreach ($caption_positions as $name => $value) { ?>
							<?php $selected = ($maxgallery->get_lightbox_caption_position() == $value) ? 'selected="selected"' : ''; ?>
							<option value="<?php echo $value ?>" <?php echo $selected ?>><?php echo $name ?></option>
						<?php } ?>
						</select>
					</td>
				</tr>
			</table>
		</div>
		
		<h4><?php _e('Image Size', 'maxgalleria-lite') ?></h4>
		<div>
			<table>
				<tr>
					<td width="100">
						<?php _e('Image Size', 'maxgalleria-lite') ?>
					</td>
					<td>
						<select class="small" id="<?php echo $maxgallery->lightbox_image_size_key ?>" name="<?php echo $maxgallery->lightbox_image_size_key ?>">
						<?php foreach ($lightbox_sizes as $name => $value) { ?>
							<?php $selected = ($maxgallery->get_lightbox_image_size() == $value) ? 'selected="selected"' : ''; ?>
							<option value="<?php echo $value ?>" <?php echo $selected ?>><?php echo $name ?></option>
						<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td width="100">
						<?php _e('Custom Width', 'maxgalleria-lite') ?>
					</td>
					<td>
						<input type="text" class="small" id="<?php echo $maxgallery->lightbox_image_size_custom_width_key ?>" name="<?php echo $maxgallery->lightbox_image_size_custom_width_key ?>" value="<?php echo $maxgallery->get_lightbox_image_size_custom_width() ?>" /> px
					</td>
				</tr>
				<tr>
					<td width="100">
						<?php _e('Custom Height', 'maxgalleria-lite') ?>
					</td>
					<td>
						<input type="text" class="small" id="<?php echo $maxgallery->lightbox_image_size_custom_height_key ?>" name="<?php echo $maxgallery->lightbox_image_size_custom_height_key ?>" value="<?php echo $maxgallery->get_lightbox_image_size_custom_height() ?>" /> px
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>