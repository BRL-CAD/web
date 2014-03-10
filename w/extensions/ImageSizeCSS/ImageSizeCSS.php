<?php
 
$wgHooks['ParserFirstCallInit'][] = 'wfImageSizeCSSInit';
 
// Hook our callback function into the parser
function wfImageSizeCSSInit( Parser $parser ) {
	// When the parser sees the <sample> tag, it executes 
	// the wfSampleRender function (see below)
	$parser->setHook( 'ol', 'wfImageSizeCSS' );
        // Always return true from this function. The return value does not denote
        // success or otherwise have meaning - it just must always be true.
	return true;
}
 
// Execute 
function wfImageSizeCSS( $input, array $args, Parser $parser, PPFrame $frame ) {
	return "hello";
}
