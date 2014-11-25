<?php
/**
 * Modern skin, derived from monobook template.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @todo document
 * @file
 * @ingroup Skins
 */

if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 * @todo document
 * @ingroup Skins
 */
class SkinModern extends SkinTemplate {
	var $skinname = 'modern', $stylename = 'modern',
		$template = 'ModernTemplate', $useHeadElement = true;

	/**
	 * @param $out OutputPage
	 */
	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );
		$out->addModuleStyles ('skins.modern');
	}
}

/**
 * @todo document
 * @ingroup Skins
 */
class ModernTemplate extends MonoBookTemplate {

	/**
	 * Template filter callback for Modern skin.
	 * Takes an associative array of data set from a SkinTemplate-based
	 * class, and a wrapper for MediaWiki's localization database, and
	 * outputs a formatted page.
	 *
	 * @access private
	 */
	function execute() {
		// Suppress warnings to prevent notices about missing indexes in $this->data
		wfSuppressWarnings();

		$this->html( 'headelement' );
?>

	<!-- heading -->
	<div id="mw_header"><div id="header-square"> </div><h1 id="firstHeading" lang="<?php
		$this->data['pageLanguage'] = $this->getSkin()->getTitle()->getPageViewLanguage()->getCode();
		$this->html( 'pageLanguage' );
	?>"><span dir="auto"><?php $this->html('title') ?></span></h1></div>
    	<div class="h-container">
	<div class="id_logo" id='logo'>
        <a href="<?php echo $wgScriptPath . "../wp" ;  ?>">
            <span class="circle" href="#"> 
                <img width="40px" height="40px" src=<?php echo $this->getSkin()->getSkinStylePath( 'logo_70.png'); ?>  />
            </span> 
        </a>
    </div>
	
	<header class="head">
			 <nav class="navbar"> 
				<ul class="navigation id_main-nav" id="main-nav">					
                    <li><a href="<?php echo $wgScriptPath . "../gallery" ; ?>">
                        <img class = "icon" src=<?php echo $this->getSkin()->getSkinStylePath( 'gallery.png'); ?>  />
                        Gallery</a></li>
                    <li><a href="<?php echo $wgScriptPath . "../wp/blog" ?>">
                        <img class = "icon" src=<?php echo $this->getSkin()->getSkinStylePath( 'wiki.png'); ?>  />
                        Blog</a></li>
                    <li><a href="<?php echo $wgScriptPath ?>">
                        <img class = "icon" src=<?php echo $this->getSkin()->getSkinStylePath( 'contribute.png'); ?>  />
                        Community</a></li> 
                    <li><a href="<?php echo $wgScriptPath . "../wiki/Documentation" ?>">
                        <img class = "icon" src=<?php echo $this->getSkin()->getSkinStylePath( 'documentation.png'); ?>  />
                        Documentation</a></li>
                    <li><a href="<?php echo $wgScriptPath . "../wp/Download" ?>"> 
                        <img class = "icon" src=<?php echo $this->getSkin()->getSkinStylePath( 'download-2.png'); ?>  />
                        Download</a></li>
                    <li class="selected">
                        <a href="<?php echo $wgScriptPath . "../wp/" ?>#about">
                             <img class = "icon" src=<?php echo $this->getSkin()->getSkinStylePath( 'home.png'); ?>  />
                            About
                        </a>
                    </li>
				</ul>
				   
			</nav>
		</header>
	</div>
    
	<div id="mw_main">
	<div id="mw_contentwrapper">
	<!-- navigation portlet -->
<?php $this->cactions(); ?>

	<!-- content -->
	<div id="mw_content" role="main">
	<!-- contentholder does nothing by default, but it allows users to style the text inside
	     the content area without affecting the meaning of 'em' in #mw_content, which is used
	     for the margins -->
	<div id="mw_contentholder" class="mw-body">
		<div class='mw-topboxes'>
			<div id="mw-js-message" style="display:none;"<?php $this->html('userlangattributes')?>></div>
			<div class="mw-topbox" id="siteSub"><?php $this->msg('tagline') ?></div>
			<?php if($this->data['newtalk'] ) {
				?><div class="usermessage mw-topbox"><?php $this->html('newtalk')  ?></div>
			<?php } ?>
			<?php if($this->data['sitenotice']) {
				?><div class="mw-topbox" id="siteNotice"><?php $this->html('sitenotice') ?></div>
			<?php } ?>
		</div>

		<div id="contentSub"<?php $this->html('userlangattributes') ?>><?php $this->html('subtitle') ?></div>

		<?php if($this->data['undelete']) { ?><div id="contentSub2"><?php     $this->html('undelete') ?></div><?php } ?>
		<?php if($this->data['showjumplinks']) { ?><div id="jump-to-nav"><?php $this->msg('jumpto') ?> <a href="#mw_portlets"><?php $this->msg('jumptonavigation') ?></a><?php $this->msg( 'comma-separator' ) ?><a href="#searchInput"><?php $this->msg('jumptosearch') ?></a></div><?php } ?>

		<?php $this->html('bodytext') ?>
		<div class='mw_clear'></div>
		<?php if($this->data['catlinks']) { $this->html('catlinks'); } ?>
		<?php $this->html ('dataAfterContent') ?>
	</div><!-- mw_contentholder -->
	</div><!-- mw_content -->
	</div><!-- mw_contentwrapper -->

	<div id="mw_portlets"<?php $this->html("userlangattributes") ?>>
	<h2><?php $this->msg( 'navigation-heading' ) ?></h2>

	<!-- portlets -->
	<?php $this->renderPortals( $this->data['sidebar'] ); ?>

	</div><!-- mw_portlets -->


	</div><!-- main -->

	<div class="mw_clear"></div>

	<!-- personal portlet -->
	<div class="portlet" id="p-personal" role="navigation">
		<h3><?php $this->msg('personaltools') ?></h3>
		<div class="pBody">
			<ul>
<?php		foreach($this->getPersonalTools() as $key => $item) { ?>
				<?php echo $this->makeListItem($key, $item); ?>

<?php		} ?>
			</ul>
		</div>
	</div>


	<!-- footer -->
	<div id="footer" role="contentinfo"<?php $this->html('userlangattributes') ?>>
			<ul id="f-list">
<?php
		foreach( $this->getFooterLinks("flat") as $aLink ) {
			if( isset( $this->data[$aLink] ) && $this->data[$aLink] ) {
?>				<li id="<?php echo$aLink?>"><?php $this->html($aLink) ?></li>
<?php 		}
		}
?>
			</ul>
<?php
		foreach ( $this->getFooterIcons("nocopyright") as $blockName => $footerIcons ) { ?>
			<div id="mw_<?php echo htmlspecialchars($blockName); ?>">
<?php
			foreach ( $footerIcons as $icon ) { ?>
				<?php echo $this->getSkin()->makeFooterIcon( $icon, 'withoutImage' ); ?>

<?php
			} ?>
			</div>
<?php
		}
?>
	</div>

	<?php $this->printTrail(); ?>
</body></html>
<?php
	wfRestoreWarnings();
	} // end of execute() method
} // end of class


