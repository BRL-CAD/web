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
 * @file
 * @ingroup Extensions
 * @authors Olivier Finlay Beaton (olivierbeaton.com) 
 * @copyright BSD-2-Clause http://www.opensource.org/licenses/BSD-2-Clause  
 * @since 2011-09-17, 0.1 
 * @note coding convention followed: http://www.mediawiki.org/wiki/Manual:Coding_conventions  
 */
 
 if ( !defined( 'MEDIAWIKI' ) ) {
        die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

/**
 * @ingroup Extensions
 * @since 2011-09-17, 0.1
 */ 
class ExtUpdateSpecialUpdate extends SpecialPage {
  const MEDIAWIKI_LINK = '[http://www.mediawiki.org/ MediaWiki]';
  const PHP_LINK = '[http://www.php.net/ PHP]';

  var $software = array();
  
  var $extensions = array();
   
  /** 
   * constructor, inits our messages
   * @since 2011-09-18, 0.1
   */     
  public function __construct() {
    // ensure we only display the page to those who have the right
    parent::__construct( 'Update', 'view-special-update' );
    
    // load our i18n messages
   // wfLoadExtensionMessages('Update');
   // wfLoadExtensionMessages('UpdateSpecial');
  } // function
  
  protected function checkExtensionUpdates($info) {
    $info['branch'] = 'stable';
    
    if ($info['branch'] == 'stable') {
    
      if (!empty($info['version']) && !empty($info['url'])) {
        // our version
        $version = trim($info['version']);
        
        // try to get the mediawiki extension page
        $url = $info['url'];
        if (preg_match('/^.+mediawiki.org\/.+\/Extension:([^\/]+)/i',$url,$matches)) {
          // it's a mediawiki extension.. let's try to get the version from the template
          $url = 'http://www.mediawiki.org/w/index.php?action=raw&title=Extension:'.$matches[1];
          
          if (ExtUpdate::debug()) {
            echo 'mediawiki url: '.$url."\n";
          } 
        } else {
          // try to fake it, it may exist, hope it's the right one!
          $url = 'http://www.mediawiki.org/w/index.php?action=raw&title=Extension:'.str_replace(' ','_',trim($info['name']));
          
          if (ExtUpdate::debug()) {
            echo 'fake mediawiki url: '.$url."\n";
          } 
        }           
        
        // look for the version in the infobox
        $req = ExtUpdate::httpGet($url);
        if ($req !== false && preg_match('/\|[ \t]*version[^=]*=([^\|]+)/i',$req,$matches)) {
          if (ExtUpdate::debug()) {
            echo 'check: '.$version.' < '.trim($matches[1])."\n";
          }
          // we think we have a version
          if (version_compare(strtolower($version),strtolower(trim($matches[1])), '<')) {
            // we do have one!
            if (ExtUpdate::debug()) {
              echo 'new version detected'."\n";
            }
            $info['update'] = trim($matches[1]);;
            
            // try to get the download links
            if (preg_match('/\|[ \t]*download[^=]*=([^\|]+)/i',$req,$matches)) {
              $info['download'] = trim($matches[1]);
            } 
                       
          }
        } // found version       
      } // have version, url
    } // branch stable  
    
    return $info;  
  } // function
  
  protected function checkMediaWikiUpdates($info) {
    $info['branch'] = 'stable';
    
    if ($info['branch'] == 'stable') {
      $stableURL = 'http://www.mediawiki.org/w/index.php?action=raw&title=Template:MW_stable_release_number';        
      $req = ExtUpdate::httpGet($stableURL);
      // is the formatting ok? do we have a version?
      if ($req !== false && preg_match('/^([^<]+)/',$req,$matches)) {
        // check if our version is lower
        if (strcmp(strtolower($info['version']),strtolower($matches[1])) < 0) {
          $info['update'] = $matches[1];
          $download = $matches[1];
          $branchURL = 'http://www.mediawiki.org/w/index.php?action=raw&title=Template:MW_stable_branch_number';
          $branchReq = ExtUpdate::httpGet($branchURL);
          if ($branchReq !== false && preg_match('/^([^<]+)/',$branchReq,$branchMatches)) {
            $info['update'] = '[http://download.wikimedia.org/mediawiki/'.$branchMatches[1].'/mediawiki-'.$matches[1].'.tar.gz '.$info['update'].']';
          }          
        }
      }
    } // stable branch
    
    return $info;
  } // function
  
  protected function checkMySQLUpdates($info) {
    $mediawiki = isset($this->software[self::MEDIAWIKI_LINK]) ? $this->software[self::MEDIAWIKI_LINK] : array();
    
    if (isset($mediawiki['branch']) && $mediawiki['branch'] == 'stable') {
      $stableURL = 'http://www.mediawiki.org/w/index.php?action=raw&title=Template:MW_stable_mysql_requirement';
      $req = ExtUpdate::httpGet($stableURL);
      // is the formatting ok? do we have a version?
      if ($req !== false && preg_match('/^([^<]+)/',$req,$matches)) {
        // check if our version is lower
        if (strcmp(strtolower($info['version']),strtolower($matches[1])) < 0) {
          $info['update'] = $matches[1];          
        }
      }
    } // stable branch
    
    return $info;
  }
  
  protected function checkPHPUpdates($info) {
    $mediawiki = isset($this->software[self::MEDIAWIKI_LINK]) ? $this->software[self::MEDIAWIKI_LINK] : array();
    
    if (isset($mediawiki['branch']) && $mediawiki['branch'] == 'stable') {
      $stableURL = 'http://www.mediawiki.org/w/index.php?action=raw&title=Template:MW_stable_php_requirement';
      $req = ExtUpdate::httpGet($stableURL);
      // is the formatting ok? do we have a version?
      if ($req !== false && preg_match('/^([^<]+)/',$req,$matches)) {
        // check if our version is lower
        if (strcmp(strtolower($info['version']),strtolower($matches[1])) < 0) {
          $info['update'] = $matches[1];          
        }
      }
    } // stable branch
    
    return $info;
  } //function
  
  /**
   * @param[in] \array basic software item info to action
   * @param[in] \array list of basic software item info   
   * @return \array changed software item info     
   * @since 2011-09-21, 0.1
   */     
  protected function checkSoftwareUpdates($info) {
  
    if (strpos($info['link'],'MediaWiki') !== false) {
      $info = $this->checkMediaWikiUpdates($info);    
    } else if (strpos($info['link'],'PHP') !== false) {
      $info = $this->checkPHPUpdates($info);
    } else if (strpos($info['link'],'MySQL') !== false) {
      $info = $this->checkMySQLUpdates($info);
    } // info  
    
    return $info;
  }
  
  /**
   * @return \string wikitext extension list
   * @since 2011-09-21, 0.1   
   */     
  protected function displayExtensions() {  
    $output = '';
    $nl = "\n";  
    
    $this->extensions = $this->getExtensionList();
    
    // Extensions
    $output .= '=='.wfMsg('update-extensions').'=='.$nl;
    $output .= '{| class="wikitable"'.$nl;
    
    $output .= '! scope="col" | '.wfMsg('update-ext-product').$nl;
    $output .= '! scope="col" | '.wfMsg('update-ext-version').$nl;
    $output .= '! scope="col" | '.wfMsg('update-ext-branch').$nl;
    $output .= '! scope="col" colspan="2" | '.wfMsg('update-ext-update').$nl;    
            
    foreach($this->extensions as $ext) {
      $output .= $this->displayExtensionItem($ext).$nl;
    }
     
    $output .= '|}'.$nl;
    
    return $output;      
  } // function  
  
  protected function displayExtensionItem($item) {
    $output = '';
    $nl = "\n";
    
    $output .= '|-'.$nl;
    $output .= '| '.(isset($item['link']) ? $item['link'] : '').$nl;
    $output .= '| '.(isset($item['version']) ? $item['version'] : '').$nl;
    $output .= '| '.(isset($item['branch']) ? $item['branch'] : '').$nl;
    $output .= '| '.(isset($item['update']) ? $item['update'] : '').$nl;
    $output .= '| './*(isset($item['download']) ? $item['download'] : '').*/$nl;
    
    return $output;
  } // function
  
  /**
   * @return \string wikitext software list  
   * @since 2011-09-21, 0.1
   */     
  protected function displaySoftware() {
    $output = '';
    $nl = "\n";
    
    $this->software = $this->getSoftwareList();
    
    // Core      
    $output .= '=='.wfMsg('update-software').'=='.$nl;
    $output .= '{| class="wikitable"'.$nl;
    $output .= '! scope="col" | '.wfMsg('update-software-product').$nl;
    $output .= '! scope="col" | '.wfMsg('update-software-version').$nl;
    $output .= '! scope="col" | '.wfMsg('update-software-branch').$nl;
    $output .= '! scope="col" | '.wfMsg('update-software-update').$nl;
    
    foreach ($this->software as $item) {
      $output .= $this->displaySoftwareItem($item).$nl;
    }
    
    $output .= '|}'.$nl; 

    return $output;      
  } // function
  
  /**
   * @param[in] \array information on a given software item
   *    \li link
   *    \li version           
   *    \li update
   *    \li download      
   * @return \string wikitext software item
   * @since 2011-09-21, 0.1
   */
  protected function displaySoftwareItem($item) {
    $output = '';
    $nl = "\n";
    
    $output .= '|-'.$nl;
    $output .= '| '.$item['link'].$nl;
    $output .= '| '.$item['version'].$nl;
    $output .= '| '.(isset($item['branch']) ? $item['branch'] : '').$nl;    
    $output .= '| '.(isset($item['update']) ? $item['update'] : '').$nl;
    
    return $output;   
  }         
  
  /**
   * entry point for the special page
   * @param[in] $par \string text after special page /  
   * @since 2011-09-19, 0.1   
   */
  public function execute($par) {
    global $wgUser,$wgOut;
    
    // make our title appear
    $this->setHeaders();
    $this->outputHeader();
    
    if ( !$wgUser->isAllowed( 'view-special-update' ) ) {
      $wgOut->permissionRequired( 'view-special-update' );
      return;
    }
    
    $output = '';
    $nl = "\n";
    
    $output .= '__NOTOC__'.$nl;
    
    $output .= $this->displaySoftware();
    $output .= $this->displayExtensions();

    $wgOut->addWikiText( $output );    
  }

  /**
   * @param[in] \array software item info  
   * @reutrn \array of software item info
   *    \li version     
   * @since 2011-09-21, 0.1
   */     
  protected static function getMediaWikiInfo($info) {
    global $wgVersion;
    
    // figure out version
    $info['version'] = $wgVersion;
    
    // could be subversion checkout
    
    return $info;
  }

  protected function getExtensionList() {
     global $wgExtensionCredits;
     
    $exts = array();
    $hashes = array();
    foreach ($wgExtensionCredits as $group=>$groupdata) {
      foreach($groupdata as $ext) {
        $hash = md5(print_r($ext,true));
        if (isset($hashes[$hash])) {
          continue; // skip this one          
        }
        $hashes[$hash] = true;
        
        // link construct
        $ext['link'] = $ext['name'];
        if (!empty($ext['url'])) {
          $ext['link'] = '['.$ext['url'].' '.$ext['link'].']';
        } 
        
        $ext = $this->checkExtensionUpdates($ext);
        
        // add to the list
        $exts[] = $ext;            
      }      
    } // credits
    
    return $exts;
  } // function
 
  /**
   * @return \array of software items \array
   *    \li link
   *    \li version
   *    \li update
   *    \li download                 
   * @since 2011-09-21, 0.1
   */       
  protected function getSoftwareList() {
    $software = array();

    // populate our list
    $mediawiki = array(
      'link' => self::MEDIAWIKI_LINK,
    );
    $mediawiki = self::getMediaWikiInfo($mediawiki);
    $software[$mediawiki['link']] = $mediawiki;
    
    $php = array(
      'link' => self::PHP_LINK,
      'version' =>  PHP_VERSION,
    );
    $software[$php['link']] = $php;

    $dbr = wfGetDB( DB_SLAVE );
    $db = array(
      'link' => $dbr->getSoftwareLink(),
      'version' => (method_exists($dbr,'getServerInfo') ? $dbr->getServerInfo() : $dbr->getServerVersion()),  
    );
    $software[$db['link']] = $db;
    
    // since mediawiki 1.15
    $hookSoftware = array();
    wfRunHooks( 'SoftwareInfo', array( &$software ) );
    
    foreach($hookSoftware as $name=>$version) {
      $software[$name] = array(
        'link' => $name,
        'version' => $version,        
      );
    }

    // check for updates
    foreach ($software as $name=>&$info) {
      $info = $this->checkSoftwareUpdates($info,$software);
    }

    // return the whole kit    
    return $software;    
  } // function
  
} // class
