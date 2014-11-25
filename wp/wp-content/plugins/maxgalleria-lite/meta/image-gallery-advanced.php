<?php
$maxgallery = new MaxGallery($post->ID);
?>

<script type="text/javascript">		
	jQuery(document).ready(function() {
		jQuery(".maxgalleria-meta .accordion.advanced").accordion({ collapsible: true, active: false, heightStyle: "auto" });
	});
</script>

<div class="maxgalleria-meta">
	<div class="accordion advanced">
		<h4><?php _e('Reset', 'maxgalleria-lite') ?></h4>
		<div>
			<div style="color: #808080; font-style: italic; padding-bottom: 10px;"><?php _e('Reset all gallery options to their default values. This action cannot be undone.', 'maxgalleria-lite') ?></div>
			<input type="checkbox" id="<?php echo $maxgallery->reset_options_key ?>" name="<?php echo $maxgallery->reset_options_key ?>" />
			<label for="<?php echo $maxgallery->reset_options_key ?>"><?php _e('Yes, I understand', 'maxgalleria-lite') ?></label>
		</div>
	</div>
</div>