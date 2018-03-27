<?php 

/*
Copyright 2011 Olivier Finlay Beaton. All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are
permitted provided that the following conditions are met:

   1. Redistributions of source code must retain the above copyright notice, this list of
      conditions and the following disclaimer.

   2. Redistributions in binary form must reproduce the above copyright notice, this list
      of conditions and the following disclaimer in the documentation and/or other materials
      provided with the distribution.

THIS SOFTWARE IS PROVIDED BY Olivier Finlay Beaton ''AS IS'' AND ANY EXPRESS OR IMPLIED
WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND
FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL Olivier Finlay Beaton OR
CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF
ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

/**
 * Extension giving new special page to see what needs updating.
 * @file
 * @ingroup Extensions
 * @version 0.1.3
 * @authors Olivier Finlay Beaton (olivierbeaton.com)  
 * @copyright BSD-2-Clause http://www.opensource.org/licenses/BSD-2-Clause  
 * @note this extension is pay-what-you-want, please consider a purchase at http://olivierbeaton.com/
 * @since 2011-09-17, 0.1
 * @note coding convention followed: http://www.mediawiki.org/wiki/Manual:Coding_conventions
 */ 

if ( !defined( 'MEDIAWIKI' ) ) {
        die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

/* (not our var to doc)
 * extension credits
 * @since 2011-09-17, 0.1
 */
$wgExtensionCredits['specialpage'][] = array(
  'name' => 'Update',
  'author' => array('[http://olivierbeaton.com/ Olivier Finlay Beaton]'), 
  'version' => '0.1.3',
  'url' => 'http://www.mediawiki.org/wiki/Extension:Update', 
  'descriptionmsg' => 'update-desc',
 );                    
 
/* (not our var to doc)
 * special page names  
 * @since 2011-09-20
 * @deprecated
 * @note here for pre 1.16 support
 */    
$wgExtensionAliasesFiles['Update'] = dirname( __FILE__ ) . '/Update.alias.php'; 
 
/* (not our var to doc)
 * Holds our internalization output strings
 * @since 2011-09-17, 0.1
 */  
$wgExtensionMessagesFiles['Update'] = dirname( __FILE__ ) . '/Update.i18n.php';
$wgExtensionMessagesFiles['UpdateSpecial'] = dirname( __FILE__ ) . '/Update.alias.php'; 

/* (not our var to doc)
 * Our extension class, has our hooks
 * @since 2011-09-20, 0.1  
 */ 
$wgAutoloadClasses['ExtUpdate'] = dirname(__FILE__) . '/Update.body.php';

/* (not our var to doc)
 * Our special page, it will load the first time the core tries to access it
 * @since 2011-09-17, 0.1  
 */ 
$wgAutoloadClasses['ExtUpdateSpecialUpdate'] = dirname(__FILE__) . '/Update.SpecialUpdate.php';

/* (not our var to doc)
 * Special page to register
 * @since 2011-09-17, 0.1  
 * @see $wgAutoloadClasses for how the class gets defined.  
 */
$wgSpecialPages['Update'] = 'ExtUpdateSpecialUpdate';

/* (not our var to doc)
 * Special page category
 * @since 2011-09-17, 0.1
 */  
$wgSpecialPageGroups['Update'] = 'wiki';

/* (not our var to doc)
 * make available the permission to view our special page
 * @since 2011-09-18, 0.1
 */  
$wgAvailableRights[] = 'view-special-update';

/* (not our var to doc)
 * make available the permission to use our special page
 * @since 2011-09-18, 0.1
 */
$wgAvailableRights[] = 'action-special-update';

/* (not our var to doc)
 * give sysop the right to view the page
 * @since 2011-09-18, 0.1
 */  
$wgGroupPermissions['sysop']['view-special-update'] = true;

/* (not our var to doc)
 * give sysop the right to use the page
 * @since 2011-09-18, 0.1
 */  
$wgGroupPermissions['sysop']['action-special-update'] = true;