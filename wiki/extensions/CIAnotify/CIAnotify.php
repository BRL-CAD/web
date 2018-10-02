<?php
/**
 * Contains code for the CIA Notify Extension.
 *
 * @addtogroup Extensions
 * @author Christopher Sean Morrison <morrison@brlcad.org>
 * @copyright Copyright (c) 2009 Christopher Sean Morrison
 * @licence MIT/X11
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "CIA Notify extension";
	exit( 1 );
}

global $wgExtensionCredits;
$wgExtensionCredits['other'][] = array(
	'name' => "CIA Notify",
	'version' => 1.0,
	'author' => "Christopher Sean Morrison",
	'description' => "Sends change notifications to the CIA IRC reporting system",
	'url' => 'http://www.mediawiki.org/wiki/Extension:CIAnotify',
);

global $wgExtensionFunctions;
$wgExtensionFunctions[] = 'efCIAnotify';

global $cnTo, $cnProject;
$cnTo = 'notify@elfga.com';

class CIAnotify {
	function notifyCIA(&$rc) {
		global $cnTo, $cnProject;

		$module = "";

		global $wgServer;
		$branch = "$wgServer";

		$revision = $rc->mAttribs['rc_this_oldid'];

		$author = $rc->mAttribs['rc_user_text'];

		$log = $rc->mAttribs['rc_comment'];

		$lines = $rc->mAttribs['rc_new_len'] - $rc->mAttribs['rc_old_len'];

		$title = Title::makeTitle($rc->mAttribs['rc_namespace'], $rc->mAttribs['rc_title']);
		$file = $title->getLocalURL();

		$url = htmlentities($title->getFullURL("oldid=$revision"));

		switch ( $rc->mAttribs['rc_type'] ) {
			case RC_EDIT:
				$action = "modify";
				break;
			case RC_NEW:
				$action = "add";
				break;
			case RC_MOVE:
				$action = "rename";
				break;
			case RC_LOG:
				$action = "log";
				break;
			case RC_MOVE_OVER_REDIRECT:
				$action = "rename";
				break;
			default:
				$action = "modify";
		}

		$timestamp = wfTimestamp( TS_UNIX, $rc->mAttribs['rc_cur_time'] );

		$notification = <<<EOF
<message>
  <generator>
    <name>CIA Notify extension to Mediawiki</name>
    <version>1.0</version>
  </generator>
  <source>
    <project>$cnProject</project>
    <module>$module</module>
    <branch>$branch</branch>
  </source>
  <body>
    <commit>
      <revision>$revision</revision>
      <author>$author</author>
      <log>$log</log>
      <diffLines>$lines</diffLines>
      <files>
        <file action="$action">$file</file>
      </files>
      <url>$url</url>
    </commit>
  </body>
  <timestamp>$timestamp</timestamp>
</message>
EOF;
		global $wgEmergencyContact;
		$header = "From: <$wgEmergencyContact>\r\nContent-type: text/xml\r\n";
		mail($cnTo, "DeliverXML", $notification);

		# all is always well
		return true;
	}
}


function efCIAnotify() {
	# add messages
	//global $wgMessageCache;
	require( dirname( __FILE__ ) . '/CIAnotify.i18n.php' );
	//foreach( $messages as $key => $value ) {
	//	$wgMessageCache->addMessages( $messages[$key], $key );
	//}

	# make sure our settings are set
	global $cnTo, $cnProject;
	if ( $cnTo == '' ) {
		die ('You need to set $cnTo to a valid CIA notifier e-mail address in order to use the CIA Notify plugin.');
	}
	if ( $cnProject == '' ) {
		die ('You need to set $cnProject in LocalSettings.php in order to use the CIA Notify plugin.');
	}

	# install the edit filter
	global $wgHooks;
	$cnObject = new CIAnotify();
	$wgHooks['RecentChange_save'][] = array( &$cnObject, 'notifyCIA' );
}
