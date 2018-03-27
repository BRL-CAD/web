<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This is an extension to the MediaWiki package and cannot be run standalone.' );
}
 
$wgExtensionCredits['skin'][] = array(
	'path' => __FILE__,
	'name' => 'BRL-CAD wp-consistent', // name as shown under [[Special:Version]]
	'namemsg' => 'brlcad-wp', // used since MW 1.24, see the section on "Localisation messages" below
	'version' => '1.0',
);

$wgValidSkinNames['brlcad-wp'] = 'brlcad-wp';
 
$wgAutoloadClasses['Skinbrlcad-wp'] = __DIR__ . '/brlcad-wp.skin.php';
$wgMessagesDirs['FooBar'] = __DIR__ . '/i18n';

$wgResourceModules['skins.brlcad-wp'] = array(
	'styles' => array(
		'resources/screen.css' => array( 'media' => 'screen' ),	),
	'remoteSkinPath' => 'brlcad-wp',
    'localBasePath' => __DIR__,