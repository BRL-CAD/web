<?php
if( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}

class SkinBrlCad extends SkinTemplate {
	/** Using monobook. */
	function initPage( &$out ) {
		SkinTemplate::initPage( $out );
		$this->skinname  = 'brlcad';
		$this->stylename = 'brlcad';
		$this->template  = 'BrlCadTemplate';
	}
}

class BrlCadTemplate extends QuickTemplate {
	function execute() {
		global $wgUser;
		$skin = $wgUser->getSkin();
		wfSuppressWarnings();
		require_once( '/usr/web/brlcad.org/skin/page.tpl.php' );
		wfRestoreWarnings();
	}
}