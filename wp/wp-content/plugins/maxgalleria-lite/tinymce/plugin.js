(function() {
	tinymce.create("tinymce.plugins.MaxGalleria", {
		init: function(editor, url) {
			editor.addCommand("mceMaxGalleria", function() {
				editor.windowManager.open(
					{
						title: "Insert Image Gallery",
						file: url + "/dialog.php",
						width: 350,
						height: 200,
						inline: 1
					},
					{ plugin_url: url }
				)}
			);
			
			editor.addButton("MaxGalleria", {
				title: "Insert Gallery",
				cmd: "mceMaxGalleria",
				image: url + "/button.png"
			})
		}
	});
	
	tinymce.PluginManager.add("MaxGalleria", tinymce.plugins.MaxGalleria);
})();
