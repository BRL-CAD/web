<?php
$maxgallery = new MaxGallery($post->ID);

$description_positions = array(
	__('Above Gallery', 'maxgalleria-lite') => 'above',
	__('Below Gallery', 'maxgalleria-lite') => 'below'
);
?>

<script type="text/javascript">		
	jQuery(document).ready(function() {
		jQuery(".maxgalleria-meta .accordion.description").accordion({ collapsible: true, active: false, heightStyle: "auto" });
	});
</script>

<div class="maxgalleria-meta">
	<div class="accordion description">
		<h4><?php _e('Description', 'maxgalleria-lite') ?></h4>
		<div>			
			<table>
				<tr>
					<td width="60">
						<label for="<?php echo $maxgallery->description_enabled_key ?>"><?php _e('Enabled', 'maxgalleria-lite') ?></label>
					</td>
					<td>
						<input type="checkbox" id="<?php echo $maxgallery->description_enabled_key ?>" name="<?php echo $maxgallery->description_enabled_key ?>" <?php echo (($maxgallery->get_description_enabled() == 'on') ? 'checked' : '') ?> />
					</td>
				</tr>
				<tr>
					<td width="60">
						<?php _e('Location', 'maxgalleria-lite') ?>
					</td>
					<td>
						<select id="<?php echo $maxgallery->description_position_key ?>" name="<?php echo $maxgallery->description_position_key ?>">
						<?php foreach ($description_positions as $name => $value) { ?>
							<?php $selected = ($maxgallery->get_description_position() == $value) ? 'selected="selected"' : ''; ?>
							<option value="<?php echo $value ?>" <?php echo $selected ?>><?php echo $name ?></option>
						<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="padding-top: 10px;">
						<label for="<?php echo $maxgallery->description_text_key ?>"><?php _e('Text', 'maxgalleria-lite') ?></label>
						<div style="vertical-align: middle; display: inline-block; color: #808080; font-style: italic; margin-left: 20px;"><?php _e('HTML is allowed', 'maxgalleria-lite') ?></div>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<textarea id="<?php echo $maxgallery->description_text_key ?>" name="<?php echo $maxgallery->description_text_key ?>"><?php echo $maxgallery->get_description_text() ?></textarea>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>