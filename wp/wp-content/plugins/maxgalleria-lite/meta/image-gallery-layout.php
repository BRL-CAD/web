<?php
global $maxgalleria;
$common = $maxgalleria->common;

$maxgallery = new MaxGallery($post->ID);

$templates = array(
	__('Image Tiles', 'maxgalleria-lite') => MAXGALLERIA_LITE_TEMPLATE_IMAGE_TILES
);

$template = $maxgallery->get_template();
$skins = $common->get_template_skins($template);
?>

<script type="text/javascript">		
	jQuery(document).ready(function() {
		jQuery(".maxgalleria-meta .accordion.layout").accordion({ collapsible: true, active: false, heightStyle: "auto" });
		
		show_template("<?php echo $maxgallery->get_template() ?>");
		jQuery("#<?php echo $maxgallery->template_key ?>_hidden").val("<?php echo $template ?>");
		
		jQuery("#<?php echo $maxgallery->template_key ?>").change(function() {
			show_template(jQuery(this).val());
			
			jQuery("#<?php echo $maxgallery->template_key ?>_hidden").val(jQuery(this).val());
			jQuery("#post").submit();
			
			return false;
		});
		
		show_skin("<?php echo $maxgallery->get_skin() ?>");
		
		jQuery("#<?php echo $maxgallery->skin_key ?>").change(function() {
			show_skin(jQuery(this).val());
		});
	});
	
	function show_template(template) {
		template_img = '<img src="<?php echo MAXGALLERIA_LITE_PLUGIN_URL ?>/templates/' + template + '/' + template + '-template.png" />';
		jQuery(".maxgalleria-meta .template-chosen").html(template_img);
		
		return false;
	}
	
	function show_skin(skin) {
		template = jQuery("#<?php echo $maxgallery->template_key ?>_hidden").val();
		skin_img = '<img src="<?php echo MAXGALLERIA_LITE_PLUGIN_URL ?>/templates/' + template + '/' + template + '-skin-' + skin + '.png" />';
		jQuery(".maxgalleria-meta .skin-chosen").html(skin_img);
		return false;
	}
</script>

<div class="maxgalleria-meta">
	<div class="accordion layout">
		<h4><?php _e('Template', 'maxgalleria-lite') ?></h4>
		<div>
			<div align="center">
				<select class="large" id="<?php echo $maxgallery->template_key ?>" name="<?php echo $maxgallery->template_key ?>">
				<?php foreach ($templates as $name => $value) { ?>
					<?php $selected = ($maxgallery->get_template() == $value) ? 'selected="selected"' : ''; ?>
					<option value="<?php echo $value ?>" <?php echo $selected ?>><?php echo $name ?></option>
				<?php } ?>
				</select>
				<div class="template-chosen"></div>
				<input type="hidden" id="<?php echo $maxgallery->template_key ?>_hidden" name="<?php echo $maxgallery->template_key ?>_hidden" />
			</div>
		</div>
		
		<h4><?php _e('Skin', 'maxgalleria-lite') ?></h4>
		<div>
			<div align="center">
				<select class="large" id="<?php echo $maxgallery->skin_key ?>" name="<?php echo $maxgallery->skin_key ?>">
				<?php foreach ($skins as $name => $value) { ?>
					<?php $selected = ($maxgallery->get_skin() == $value) ? 'selected="selected"' : ''; ?>
					<option value="<?php echo $value ?>" <?php echo $selected ?>><?php echo $name ?></option>
				<?php } ?>
				</select>
				<div class="skin-chosen"></div>
			</div>
		</div>
	</div>
</div>