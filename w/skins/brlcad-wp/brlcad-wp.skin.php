<?php
/**
 * Skin file for skin brlcad-wp.
 *
 * @file
 * @ingroup Skins
 */
 
 class Skinbrlcad-wp extends SkinTemplate {
	var $skinname = 'brlcad-wp', $stylename = 'brlcad-wp',
		$template = 'brlcad-wpTemplate', $useHeadElement = true;
 
 
	/**
	 * Add CSS via ResourceLoader
	 *
	 * @param $out OutputPage
	 */
	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );
		$out->addModuleStyles( array(
			'mediawiki.skinning.interface', 'skins.brlcad-wp'
		) );
	}
}

/**
 * BaseTemplate class for Foo Bar skin
 *
 * @ingroup Skins
 */
class brlcad-wpTemplate extends BaseTemplate {
	/**
	 * Outputs the entire contents of the page
	 */
	public function execute() {
		$this->html( 'headelement' ); ?>
 
// [...]
 
<?php $this->printTrail(); ?>
</body>
</html><?php
	}
}