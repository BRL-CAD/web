jQuery(document).ready(function() {
	if (maxgallery["lightbox_caption_enabled"] == "on") {
		if (maxgallery["lightbox_caption_position"] == "bottom") {
			jQuery(".mg-image-tiles .mg-thumbs a").fancybox({ "titleShow": true, "titlePosition": "over" });
		}
		
		if (maxgallery["lightbox_caption_position"] == "below") {
			jQuery(".mg-image-tiles .mg-thumbs a").fancybox({ "titleShow": true, "titlePosition": "inside" });
		}
	}
	else {
		jQuery(".mg-image-tiles .mg-thumbs a").fancybox({ "titleShow": false });
	}
});