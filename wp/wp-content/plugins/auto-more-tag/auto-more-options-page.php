<?php
function hasErrors($messages) {
	return count($messages['errors']) > 0;
}

function hasNotices($messages) {
	return count($messages['notices']) > 0;
}

function hasWarnings($messages) {
	return count($messages['warnings']) > 0;
}
?>
<div class="wrap">
	<h2>Auto More Tag by <a href="http://travisweston.com/">Travis Weston</a></h2>
		<?php $options = get_option('tw_auto_more_tag'); 
			if(isset($_GET['settings-updated']) && isset($options['auto_update']) && $options['auto_update'] == true){
				$this->updateAll();
			}
		?>
		<?php
			if(hasErrors($options['messages']) || hasNotices($options['messages']) || hasWarnings($options['messages'])){
		?>
	<div id="auto_more_tags" class="error settings-error">
		<?php
			if(hasErrors($options['messages'])){
		?>
		<h3>ERRORS:</h3>
		<?php		
				foreach($options['messages']['errors'] as $error){
		?>
		<p style="padding-left: 25px;"><?php echo $error; ?></p>
		<?php
				}
				$options['messages']['errors'] = array();
			} 

			if(hasNotices($options['messages'])){
		?>
		<h3>Notices:</h3>
		<?php		
				foreach($options['messages']['notices'] as $error){
		?>
		<p style="padding-left: 25px;"><?php echo $error; ?></p>
		<?php
				}
				$options['messages']['notices'] = array();
			} 

			if(hasWarnings($options['messages'])){
		?>
		<h3>Warnings:</h3>
		<?php		
				foreach($options['messages']['warnings'] as $error){
		?>
		<p style="padding-left: 25px;"><?php echo $error; ?></p>
		<?php
				}
				$options['messages']['warnings'] = array();
			} 

		?>
	</div>
				<?php
				
				update_option('tw_auto_more_tag', $options);
			}

		?>
	<hr style="width: 80%;" />
	<div style="padding: 10px 10px 10px 10px;">
		<form method="post" action="options.php">
			<?php settings_fields('tw_auto_more_tag'); ?>
			<div>
				<label for="tw_auto_more_tag[quantity]">Add More Tag after:</label>
				<input id="tw_auto_more_tag[quantity]" name="tw_auto_more_tag[quantity]" value="<?php echo isset($options['quantity']) ? $options['quantity'] : 200; ?>" />
			</div>
			<div>
				<label for="tw_auto_more_tag[units]">Characters, Words or Percent of Post?</label>
				<select id="tw_auto_more_tag[units]" name="tw_auto_more_tag[units]">
					<option value="1" <?php echo ($options['units'] == 1 || !isset($options['units'])) ? 'selected="SELECTED" ' : null; ?>/>Characters
					<option value="2" <?php echo ($options['units'] == 2) ? 'selected="SELECTED" ' : null; ?>/>Words
					<option value="3" <?php echo ($options['units'] == 3) ? 'selected="SELECTED" ' : null; ?>/>Percent
				</select>
			</div>
			<div>
				<label for="tw_auto_more_tag[break]">Break On?</label>
				<select id="tw_auto_more_tag[break]" name="tw_auto_more_tag[break]">
					<option value="1" <?php echo ($options['break'] == 1 || !isset($options['break'])) ? 'selected="SELECTED" ' : null; ?>/>Space
					<option value="2" <?php echo ($options['break'] == 2) ? 'selected="SELECTED" ' : null; ?>/>End of Line
				</select>
			</div>
			<div>
				<label for="tw_auto_more_tag[auto_update]">Auto Update Posts On Settings Update?</label>
				<select id="tw_auto_more_tag[auto_update]" name="tw_auto_more_tag[auto_update]">
					<option value="1" <?php echo (isset($options['auto_update']) && $options['auto_update'] == true) ? 'selected="SELECTED" ' : null;?>/>Yes
					<option value="0" <?php echo (!isset($options['auto_update']) || $options['auto_update'] == false) ? 'selected="SELECTED" ' : null;?>/>No
				</select>
			</div>
			<div>
				<label for="tw_auto_more_tag[ignore_man_tag]">Ignore Manually Inserted Tags?</label>
				<select id="tw_auto_more_tag[ignore_man_tag]" name="tw_auto_more_tag[ignore_man_tag]">
					<option value="1" <?php echo (!isset($options['ignore_man_tag']) || $options['ignore_man_tag'] == true) ? 'selected="SELECTED" ' : null;?>/>Yes
					<option value="0" <?php echo (isset($options['ignore_man_tag']) && $options['ignore_man_tag'] == false) ? 'selected="SELECTED" ' : null;?>/>No
				</select>
			</div>
			<div>
				<label for="tw_auto_more_tag[set_pages]">Set More Tag On Pages?</label>
				<select id="tw_auto_more_tag[set_pages]" name="tw_auto_more_tag[set_pages]">
					<option value="0" <?php echo (!isset($options['set_pages']) || $options['set_pages'] == false) ? 'selected="SELECTED" ' : null;?>/>No
					<option value="1" <?php echo (isset($options['set_pages']) && $options['set_pages'] == true) ? 'selected="SELECTED" ' : null;?>/>Yes
				</select>
			</div>
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Update Auto More Tag Settings'); ?>" />
			</p>
		</form>
	</div>
</div>
