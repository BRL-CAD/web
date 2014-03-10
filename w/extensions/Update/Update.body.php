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
 * @since 2011-09-20, 0.1  
 * @note coding convention followed: http://www.mediawiki.org/wiki/Manual:Coding_conventions  
 */
 
 if ( !defined( 'MEDIAWIKI' ) ) {
        die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

/**
 * @ingroup Extensions
 * @since 2011-09-20, 0.1  
 */ 
class ExtUpdate {
  /**
   * User agent strings for http requests coming from our extension  
   * @since 2011-09-19, 0.1
   */     
  const userAgent = 'MediaWiki, Extension:Update';
  
  /**
   * Specify the <em>eu-debug=true</em> key/value pair in your GET parameters 
   *  to see the debug messages from this extension about the replacements it's doing.
   *  @note populated on first call to debug(), null until then 
   *  @since 2011-09-17, 0.1 
   */ 
  protected static $debug = null;
  
  /** 
   * constructor, inits our messages
   * @since 2011-09-18, 0.1
   */     
  public function __construct() {    
    // load our i18n messages
    wfLoadExtensionMessages('Update');
  }
  
  /**
   * checks if we are printing debug messages
   * @return \bool true/false
   * @since 2011-09-17, 0.1
   * @note sets $debug if set to null based on <em>ux-debug</em> parameter   
   * @todo use $out->getRequest for 1.18         
   */     
  public static function debug() {
    global $wgRequest;
    if (self::$debug === null) {
      self::$debug = $wgRequest->getBool('upt-debug');
    }
    return self::$debug;
  } // function
  
  /**
   * sets user agent before getting a HTTP page
   * @param[in] \string $url to fetch
   * @param[in] \array $options to set
   * @return \mixed false (\bool) on failure, \string page contents on success
   * @since 2010-09-19, 0.1
   * @note detects class names for MediaWiki <= 1.16   
   */                 
  public static function httpGet($url,$options=null) {
    if (class_exists('MWHttpRequest') || class_exists('HttpRequest')) {
      // MWHttpRequest is 1.17+
      // HttpRequest is 1.16
      $httpRequest = class_exists('MWHttpRequest') ? 'MWHttpRequest' : 'HttpRequest';
        
      $req = call_user_func( array($httpRequest, 'factory'), $url, $options );
      $req->setUserAgent( self::userAgent );
      $status = $req->execute();
      
      return $status->isOK() ? $req->getContent() : false;
    } else {
      // Http::request is pre 1.16
      
      // without curl, no custom non-mw user-agent, sorry
      $status = Http::request('GET',$url,'default',array(CURLOPT_USERAGENT=>self::userAgent));
      return is_string($status) ? $status : false;    
    }
    
    return false;    
  } //function

} // class
