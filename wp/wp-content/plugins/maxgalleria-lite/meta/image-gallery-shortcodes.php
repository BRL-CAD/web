<p><?php _e('Use either of the following shortcodes to display this gallery:', 'maxgalleria-lite') ?></p>

<textarea readonly style="width: 100%; height: 45px; font-weight: bold;">[maxgallery id="<?php echo $post->ID ?>"]</textarea>

<?php if ($post->post_status == 'publish') { ?>
	<textarea readonly style="width: 100%; height: 45px; font-weight: bold;">[maxgallery name="<?php echo $post->post_name ?>"]</textarea>
<?php } ?>