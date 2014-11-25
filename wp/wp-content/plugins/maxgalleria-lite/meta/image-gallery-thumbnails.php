<?php
$maxgallery = new MaxGallery($post->ID);

$thumb_shapes = array(
	__('Landscape', 'maxgalleria-lite') => MAXGALLERIA_LITE_THUMB_SHAPE_LANDSCAPE,
	__('Portrait', 'maxgalleria-lite') => MAXGALLERIA_LITE_THUMB_SHAPE_PORTRAIT,
	__('Square', 'maxgalleria-lite') => MAXGALLERIA_LITE_THUMB_SHAPE_SQUARE
);

$caption_positions = array(
	__('Below Image', 'maxgalleria-lite') => 'below',
	__('Bottom of Image', 'maxgalleria-lite') => 'bottom'
);

$thumb_clicks = array(
	__('Lightbox Image', 'maxgalleria-lite') => 'lightbox',
	__('Image Page', 'maxgalleria-lite') => 'attachment_image_page',
	__('Image Link', 'maxgalleria-lite') => 'attachment_image_link',
	__('Original Image', 'maxgalleria-lite') => 'attachment_image_source'
);
?>

<script type="text/javascript">		
	jQuery(document).ready(function() {
		jQuery(".maxgalleria-meta .accordion.thumbnails").accordion({ collapsible: true, active: false, heightStyle: "auto" });
		
		enableDisableThumbClickNewWindow();
		
		jQuery("#<?php echo $maxgallery->thumb_columns_key ?>").val(<?php echo $maxgallery->get_thumb_columns() ?>);
		show_columns_image(<?php echo $maxgallery->get_thumb_columns() ?>);
		
		jQuery("#thumb_columns_slider").slider({
			range: "min",
			value: <?php echo $maxgallery->get_thumb_columns() ?>,
			min: 1,
			max: 10,
			step: 1,
			slide: function(event, ui) {
				jQuery("#thumb_columns_slider_result").html(ui.value);
				jQuery("#<?php echo $maxgallery->thumb_columns_key ?>").val(ui.value);
				show_columns_image(ui.value);
			},
			change: function(event, ui) {
				jQuery("#<?php echo $maxgallery->thumb_columns_key ?>").val(ui.value);
				show_columns_image(ui.value);
			}
		});
		
		show_thumb_shape("<?php echo $maxgallery->get_thumb_shape() ?>");
		
		jQuery("#<?php echo $maxgallery->thumb_shape_key ?>").change(function() {
			show_thumb_shape(jQuery(this).val());
		});
		
		jQuery("#<?php echo $maxgallery->thumb_click_key ?>").change(function() {
			enableDisableThumbClickNewWindow();
		});
	});
	
	function enableDisableThumbClickNewWindow() {
		thumb_click = jQuery("#<?php echo $maxgallery->thumb_click_key ?>").val();
		
		if (thumb_click == "lightbox") {
			jQuery("#<?php echo $maxgallery->thumb_click_new_window_key ?>").attr("disabled", "disabled");
			jQuery("#<?php echo $maxgallery->thumb_click_new_window_key ?>").removeAttr("checked");
		}
		else {
			jQuery("#<?php echo $maxgallery->thumb_click_new_window_key ?>").removeAttr("disabled");
		}
	}
	
	function show_columns_image(size) {
		template = jQuery("#<?php echo $maxgallery->template_key ?>_hidden").val();
		columns_img = '<img src="<?php echo MAXGALLERIA_LITE_PLUGIN_URL ?>/templates/' + template + '/' + template + '-template-' + size + 'col.png" />';
		jQuery("#thumb_columns_image").html(columns_img);
	}
	
	function show_thumb_shape(shape) {
		shape_img = '<img src="<?php echo MAXGALLERIA_LITE_PLUGIN_URL ?>/images/thumb-shape-' + shape + '.png" />';
		jQuery(".maxgalleria-meta .thumb-shape-chosen").html(shape_img);
	}
</script>

<div class="maxgalleria-meta">
	<div class="accordion thumbnails">
		<h4><?php _e('Columns', 'maxgalleria-lite') ?></h4>
		<div>
			<div align="center">
				<div id="thumb_columns_slider_result" class="value-slider-result"><?php echo $maxgallery->get_thumb_columns() ?></div>
				<div id="thumb_columns_slider" class="value-slider"></div>
				<div id="thumb_columns_image" style="padding-top: 20px;"></div>
				<input type="hidden" id="<?php echo $maxgallery->thumb_columns_key ?>" name="<?php echo $maxgallery->thumb_columns_key ?>" />
			</div>
		</div>
		
		<h4><?php _e('Shape', 'maxgalleria-lite') ?></h4>
		<div>
			<div align="center">
				<select class="large" id="<?php echo $maxgallery->thumb_shape_key ?>" name="<?php echo $maxgallery->thumb_shape_key ?>">
				<?php foreach ($thumb_shapes as $name => $value) { ?>
					<?php $selected = ($maxgallery->get_thumb_shape() == $value) ? 'selected="selected"' : ''; ?>
					<option value="<?php echo $value ?>" <?php echo $selected ?>><?php echo $name ?></option>
				<?php } ?>
				</select>
				<div class="thumb-shape-chosen"></div>
			</div>
		</div>
		
		<h4><?php _e('Captions', 'maxgalleria-lite') ?></h4>
		<div>
			<table>
				<tr>
					<td width="60">
						<label for="<?php echo $maxgallery->thumb_caption_enabled_key ?>"><?php _e('Enabled', 'maxgalleria-lite') ?></label>
					</td>
					<td>
						<input type="checkbox" id="<?php echo $maxgallery->thumb_caption_enabled_key ?>" name="<?php echo $maxgallery->thumb_caption_enabled_key ?>" <?php echo (($maxgallery->get_thumb_caption_enabled() == 'on') ? 'checked' : '') ?> />
					</td>
				</tr>
				<tr>
					<td width="60">
						<?php _e('Position', 'maxgalleria-lite') ?>
					</td>
					<td>
						<select id="<?php echo $maxgallery->thumb_caption_position_key ?>" name="<?php echo $maxgallery->thumb_caption_position_key ?>">
						<?php foreach ($caption_positions as $name => $value) { ?>
							<?php $selected = ($maxgallery->get_thumb_caption_position() == $value) ? 'selected="selected"' : ''; ?>
							<option value="<?php echo $value ?>" <?php echo $selected ?>><?php echo $name ?></option>
						<?php } ?>
						</select>
					</td>
				</tr>
			</table>
		</div>
		
		<h4><?php _e('Click', 'maxgalleria-lite') ?></h4>
		<div>
			<table>
				<tr>
					<td colspan="2">
						<strong><?php _e('Thumb Click Should Open', 'maxgalleria-lite') ?></strong>
						<br />
						<select id="<?php echo $maxgallery->thumb_click_key ?>" name="<?php echo $maxgallery->thumb_click_key ?>">
						<?php foreach ($thumb_clicks as $name => $value) { ?>
							<?php $selected = ($maxgallery->get_thumb_click() == $value) ? 'selected="selected"' : ''; ?>
							<option value="<?php echo $value ?>" <?php echo $selected ?>><?php echo $name ?></option>
						<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td>
						<input type="checkbox" id="<?php echo $maxgallery->thumb_click_new_window_key ?>" name="<?php echo $maxgallery->thumb_click_new_window_key ?>" <?php echo (($maxgallery->get_thumb_click_new_window() == 'on') ? 'checked' : '') ?> />
					</td>
					<td>
						<label for="<?php echo $maxgallery->thumb_click_new_window_key ?>"><?php _e('Open in New Window', 'maxgalleria-lite') ?></label>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<div style="color: #808080; font-style: italic; padding-bottom: 10px;"><?php _e('Does not apply if Lightbox Image is selected.', 'maxgalleria-lite') ?></div>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>