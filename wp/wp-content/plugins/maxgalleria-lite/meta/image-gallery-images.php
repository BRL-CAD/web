<?php
global $post;
global $maxgalleria;

$image_gallery = $maxgalleria->image_gallery;

$maxgallery = new MaxGallery($post->ID);

$args = array(
	'post_type' => 'attachment',
	'numberposts' => -1, // All of them
	'post_parent' => $post->ID,
	'orderby' => 'menu_order',
	'order' => 'ASC'
);

$attachments = get_posts($args);
?>

<script type="text/javascript">		
	jQuery(document).ready(function() {
		// To add the image count in the meta box title
		jQuery("#image-gallery-images h3.hndle span").html("<?php _e('Images', 'maxgalleria-lite') ?> (<?php echo count($attachments) ?>)");
		
		// Image moving and re-ordering
		jQuery("#gallery-media").dataTable({ bPaginate: false }).rowReordering({
			fnAlert: function(message) {
				alert(message);
			},
			fnSuccess: function() {
				reorderImages();
			}
		});
		
		// Lightbox
		jQuery("a.lightbox").fancybox();
		
		// Need the menu order table cell, but don't need to show it
		jQuery("th.order").css("display", "none");
		jQuery("td.order").css("display", "none");
		
		jQuery("#gallery_media_select_button").click(function() {
			jQuery(".maxgalleria-meta .add-media .source").toggle();
		});
		
		jQuery("#gallery_media_source_computer").click(function() {
			post_id = <?php echo $post->ID ?>;
			tb_show("<?php _e('Add Images', 'maxgalleria-lite') ?>", "media-upload.php?post_id=" + post_id + "&context=maxgalleria&type=image&tab=type&TB_iframe=true");
			jQuery(".maxgalleria-meta .add-media .source").hide();
			return false;
		});
		
		jQuery("#gallery_media_source_close").click(function() {
			jQuery(".maxgalleria-meta .add-media .source").hide();
		});
		
		// The image_id is the result of media_send_to_editor
		window.send_to_editor = function(image_id) {
			jQuery("#gallery_dummy").val(image_id);
			reloadPage();
		};
		
		jQuery(window).bind("tb_unload", function() {
			reloadPage();
		});
		
		jQuery("#gallery_dummy").change(function() {
			reloadPage();
		});
		
		jQuery(".maxgalleria-meta .media table td").hover(
			function() {
				jQuery(this).find(".actions").css("visibility", "visible");
				jQuery(this).siblings().find(".actions").css("visibility", "visible");
			},
			function() {
				jQuery(this).find(".actions").css("visibility", "hidden");
				jQuery(this).siblings().find(".actions").css("visibility", "hidden");
			}
		);
		
		jQuery("#select-all").click(function() {
			 jQuery("input[type='checkbox']").attr("checked", jQuery("#select-all").is(":checked")); 
		});
		
		jQuery("#bulk-action-apply").click(function() {
			var bulk_action = jQuery("#bulk-action-select").val();
			
			var form_data = jQuery("#post").serialize();
			var data_action = "";
			
			if (bulk_action == "exclude") { data_action = form_data + "&action=exclude_bulk_images_from_gallery"; }
			if (bulk_action == "include") { data_action = form_data + "&action=include_bulk_images_in_gallery"; }
			if (bulk_action == "remove") { data_action = form_data + "&action=remove_bulk_images_from_gallery"; }
			
			if (data_action != "") {
				jQuery.ajax({
					type: "POST",
					url: "<?php echo admin_url('admin-ajax.php') ?>",
					data: data_action,
					success: function(message) {
						if (message != "") {
							alert(message);
							reloadPage();
						}
					}
				});
			}
			
			return false;
		});
		
		jQuery("#list-view").on("click", function(e) {
			e.preventDefault(); 
			jQuery("#rows-view").removeClass("active");
			jQuery("#grid-view").removeClass("active");
			jQuery(this).addClass("active");
			jQuery("#gallery-media_wrapper").removeClass("rows images");
			jQuery("#gallery-media_wrapper").removeClass("grid");
			jQuery("#gallery-media_wrapper").addClass("list");
			jQuery(".maxgalleria-meta .bulk-actions").show();
		});

		jQuery("#rows-view").on("click", function(e) {
			e.preventDefault(); 
			jQuery("#list-view").removeClass("active");
			jQuery("#grid-view").removeClass("active");
			jQuery(this).addClass("active");
			jQuery("#gallery-media_wrapper").removeClass("list");
			jQuery("#gallery-media_wrapper").removeClass("grid");
			jQuery("#gallery-media_wrapper").addClass("rows images");
			jQuery(".maxgalleria-meta .bulk-actions").show();
		});

		jQuery("#grid-view").on("click", function(e) {
			e.preventDefault(); 
			jQuery("#list-view").removeClass("active");
			jQuery("#rows-view").removeClass("active");
			jQuery(this).addClass("active");
			jQuery("#gallery-media_wrapper").removeClass("list");
			jQuery("#gallery-media_wrapper").removeClass("rows images");
			jQuery("#gallery-media_wrapper").addClass("grid");
			jQuery(".maxgalleria-meta .bulk-actions").hide();
		});
	});
	
	function editImage(image_id) {
		tb_show("<?php _e('Edit Image', 'maxgalleria-lite') ?>", "<?php echo MAXGALLERIA_LITE_PLUGIN_URL ?>/meta/image-edit.php?image_id=" + image_id + "&TB_iframe=true");
		return false;
	}
	
	function removeImage(image_id) {
		var result = confirm("<?php _e('Are you sure you want to remove this image from the gallery?', 'maxgalleria-lite') ?>");
		if (result == true) {
			var nonce_value = jQuery("#<?php echo $image_gallery->nonce_image_remove_single['name'] ?>").val();
			
			jQuery.ajax({
				type: "POST",
				url: "<?php echo admin_url('admin-ajax.php') ?>",
				data: {
					action: 'remove_single_image_from_gallery',
					id: image_id,
					<?php echo $image_gallery->nonce_image_remove_single['name'] ?>: nonce_value
				},
				success: function(message) {
					if (message != "") {
						alert(message);
						reloadPage();
					}
				}
			});
			
			return false;
		}
	}
	
	function excludeImage(image_id) {
		var result = confirm("<?php _e('Are you sure you want to exclude this image from the gallery?', 'maxgalleria-lite') ?>");
		if (result == true) {
			var nonce_value = jQuery("#<?php echo $image_gallery->nonce_image_exclude_single['name'] ?>").val();
			
			jQuery.ajax({
				type: "POST",
				url: "<?php echo admin_url('admin-ajax.php') ?>",
				data: {
					action: 'exclude_single_image_from_gallery',
					id: image_id,
					<?php echo $image_gallery->nonce_image_exclude_single['name'] ?>: nonce_value
				},
				success: function(message) {
					if (message != "") {
						alert(message);
						reloadPage();
					}
				}
			});
			
			return false;
		}
	}
	
	function includeImage(image_id) {
		var result = confirm("<?php _e('Are you sure you want to include this image in the gallery?', 'maxgalleria-lite') ?>");
		if (result == true) {
			var nonce_value = jQuery("#<?php echo $image_gallery->nonce_image_include_single['name'] ?>").val();
			
			jQuery.ajax({
				type: "POST",
				url: "<?php echo admin_url('admin-ajax.php') ?>",
				data: {
					action: 'include_single_image_in_gallery',
					id: image_id,
					<?php echo $image_gallery->nonce_image_include_single['name'] ?>: nonce_value
				},
				success: function(message) {
					if (message != "") {
						alert(message);
						reloadPage();
					}
				}
			});
			
			return false;
		}
	}
	
	function reorderImages() {
		jQuery(".maxgalleria-meta .media table td.order").each(function() {
			jQuery(this).siblings().find(".media-order-input").val(jQuery(this).html());
		});
		
		var form_data = jQuery("#post").serialize();
		
		jQuery.ajax({
			type: "POST",
			url: "<?php echo admin_url('admin-ajax.php') ?>",
			data: form_data + "&action=reorder_images"
		});
		
		return false;
	}
	
	function reloadPage() {
		tb_remove();
		window.location = "<?php echo admin_url() ?>post.php?post=<?php echo $post->ID ?>&action=edit";
	}
</script>

<div class="maxgalleria-meta">
	<div class="add-media">
		<input type="button" class="btn btn-primary" id="gallery_media_select_button" name="gallery_media_select_button" value="<?php _e('Add Images', 'maxgalleria-lite') ?>" />
		<input type="hidden" id="gallery_dummy" name="gallery_dummy" />
		<div class="source">
			<div class="header">
				<div class="title"><?php _e('Source', 'maxgalleria-lite') ?></div>
				<div class="close"><a href="#" id="gallery_media_source_close"><img src="<?php echo MAXGALLERIA_LITE_PLUGIN_URL ?>/images/source-close.png" /></a></div>
				<div class="clear"></div>
			</div>
			<ul>
				<li><a href="#" id="gallery_media_source_computer"><img src="<?php echo MAXGALLERIA_LITE_PLUGIN_URL ?>/images/source-computer-24.png" /><?php _e('My Computer', 'maxgalleria-lite') ?></a></li>
				<li><img src="<?php echo MAXGALLERIA_LITE_PLUGIN_URL ?>/images/source-library-24.png" /><?php _e('Media Library', 'maxgalleria-lite') ?><span class="asterisk"><?php printf(__('* Available in the %sfull version%s', 'maxgalleria-lite'), '<a href="' . admin_url() . 'edit.php?post_type=' . MAXGALLERIA_LITE_POST_TYPE . '&page=maxgalleria-full-version">', '</a>') ?></span></li>
			</ul>
		</div>
	</div>
	<?php if (count($attachments) > 0) { ?>
		<div class="bulk-actions">
			<select name="bulk-action-select" id="bulk-action-select">
				<option value=""><?php _e('Bulk Actions', 'maxgalleria-lite') ?></option>
				<option value="exclude"><?php _e('Exclude', 'maxgalleria-lite') ?></option>
				<option value="include"><?php _e('Include', 'maxgalleria-lite') ?></option>
				<option value="remove"><?php _e('Remove', 'maxgalleria-lite') ?></option>
			</select>
			<input type="button" id="bulk-action-apply" class="button" value="<?php _e('Apply', 'maxgalleria-lite') ?>" />
		</div>
		<ul class="views">
			<li><a id="list-view" class="active"><?php _e('List', 'maxgalleria-lite') ?></a></li>
			<li><a id="rows-view"><?php _e('Rows', 'maxgalleria-lite') ?></a></li>
			<li><a id="grid-view"><?php _e('Grid', 'maxgalleria-lite') ?></a></li>
		</ul>
	<?php } ?>
	<div class="clear"></div>
	
	<div class="media">				
		<?php if (count($attachments) < 1) { ?>
			<h4><?php _e('No images have been added to this gallery.', 'maxgalleria-lite') ?></h4>
		<?php } else { ?>
			<table id="gallery-media" cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						<th class="order">&nbsp;</th>
						<th class="checkbox"><input type="checkbox" name="select-all" id="select-all" /></th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th class="reorder"><?php _e('Reorder', 'maxgalleria-lite') ?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($attachments as $attachment) { ?>
					<?php $is_excluded = get_post_meta($attachment->ID, 'maxgallery_attachment_image_exclude', true) ?>
					
					<tr id="<?php echo $attachment->ID ?>">
						<td class="order"><?php echo $attachment->menu_order ?></td>
						<td class="checkbox">
							<input type="checkbox" name="media-id[]" id="media-id-<?php echo $attachment->ID ?>" value="<?php echo $attachment->ID ?>" />
							<input type="hidden" name="media-order[]" id="media-order-<?php echo $attachment->ID ?>" value="<?php echo $attachment->menu_order ?>" class="media-order-input" />
							<input type="hidden" name="media-order-id[]" id="media-order-id-<?php echo $attachment->ID ?>" value="<?php echo $attachment->ID ?>" />
						</td>
						<td class="thumb image">
							<a href="<?php echo $attachment->guid ?>" class="lightbox" rel="media">
								<?php if ($is_excluded == true) { ?>
									<div class="exclude">
										<?php echo wp_get_attachment_image($attachment->ID, MAXGALLERIA_LITE_META_IMAGE_THUMB_SMALL) ?>
									</div>
								<?php } else { ?>
									<?php echo wp_get_attachment_image($attachment->ID, MAXGALLERIA_LITE_META_IMAGE_THUMB_SMALL) ?>
								<?php } ?>
							</a>
							<div class="actions">
								<a href="#" title="<?php _e('Edit', 'maxgalleria-lite') ?>" onclick="javascript:editImage(<?php echo $attachment->ID ?>); return false;"><?php _e('Edit', 'maxgalleria-lite') ?></a> |
								<a href="#" title="<?php _e('Remove', 'maxgalleria-lite') ?>" onclick="javascript:removeImage(<?php echo $attachment->ID ?>); return false;"><?php _e('Remove', 'maxgalleria-lite') ?></a> |
								
								<?php if ($is_excluded) { ?>
									<a href="#" title="<?php _e('Include', 'maxgalleria-lite') ?>" onclick="javascript:includeImage(<?php echo $attachment->ID ?>); return false;"><?php _e('Include', 'maxgalleria-lite') ?></a>
								<?php } else { ?>
									<a href="#" title="<?php _e('Exclude', 'maxgalleria-lite') ?>" onclick="javascript:excludeImage(<?php echo $attachment->ID ?>); return false;"><?php _e('Exclude', 'maxgalleria-lite') ?></a>
								<?php } ?>
							</div>
						</td>
						<td class="text">
							<div class="details">
								<div class="detail-label"><?php _e('Title', 'maxgalleria-lite') ?>:</div>
								<div class="detail-value title-value"><?php echo $attachment->post_title ?></div>
								<div class="clear"></div>
								
								<div class="detail-label"><?php _e('Alt Text', 'maxgalleria-lite') ?>:</div>
								<div class="detail-value"><?php echo get_post_meta($attachment->ID, '_wp_attachment_image_alt', true) ?></div>
								<div class="clear"></div>
								
								<div class="detail-label"><?php _e('Caption', 'maxgalleria-lite') ?>:</div>
								<div class="detail-value"><?php echo $attachment->post_excerpt ?></div>
								<div class="clear"></div>
								
								<div class="detail-label"><?php _e('Meta', 'maxgalleria-lite') ?>:</div>
								<div class="detail-value">
									<?php echo $image_gallery->get_image_size_display($attachment) ?> |
									<?php echo $attachment->post_mime_type ?> |
									<?php echo date(get_option('date_format'), strtotime($attachment->post_date)) ?>
								</div>
								<div class="clear"></div>
								
								<div class="detail-label"><?php _e('Link', 'maxgalleria-lite') ?>:</div>
								<div class="detail-value">
									<a href="<?php echo get_post_meta($attachment->ID, 'maxgallery_attachment_image_link', true) ?>" target="_blank">
										<?php echo get_post_meta($attachment->ID, 'maxgallery_attachment_image_link', true) ?>
									</a>
								</div>
								<div class="clear"></div>
							</div>
						</td>
						<td class="reorder">
							<div class="reorder-media">
							</div>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
			
			<?php wp_nonce_field($image_gallery->nonce_image_exclude_single['action'], $image_gallery->nonce_image_exclude_single['name']) ?>
			<?php wp_nonce_field($image_gallery->nonce_image_exclude_bulk['action'], $image_gallery->nonce_image_exclude_bulk['name']) ?>
			<?php wp_nonce_field($image_gallery->nonce_image_include_single['action'], $image_gallery->nonce_image_include_single['name']) ?>
			<?php wp_nonce_field($image_gallery->nonce_image_include_bulk['action'], $image_gallery->nonce_image_include_bulk['name']) ?>
			<?php wp_nonce_field($image_gallery->nonce_image_remove_single['action'], $image_gallery->nonce_image_remove_single['name']) ?>
			<?php wp_nonce_field($image_gallery->nonce_image_remove_bulk['action'], $image_gallery->nonce_image_remove_bulk['name']) ?>
			<?php wp_nonce_field($image_gallery->nonce_image_reorder['action'], $image_gallery->nonce_image_reorder['name']) ?>
		<?php } ?>
	</div>
</div>
