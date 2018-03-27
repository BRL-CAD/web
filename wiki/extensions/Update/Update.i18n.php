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

/* (not our var to doc)
 * Message names
 * @since 2011-09-18, 0.1
 * @note 'update' for special page name 
 */   
$messages = array();


/*

    English

*/

/** English
 * @author Olivier Finlay Beaton
 */
$messages['en'] = array(
  'update' => 'Update',
  'update-desc' => 'Special page showing what needs updating',
  
  'update-software' => 'Installed software',
  'update-software-product' => 'Product',
  'update-software-version' => 'Version',
  'update-software-branch' => 'Branch',
  'update-software-update' => 'Update',
  
  'update-extensions' => 'Extensions',  
  'update-ext-product' => 'product',
  'update-ext-version' => 'Version',
  'update-ext-branch' => 'Branch',
  'update-ext-update' => 'Update',
);