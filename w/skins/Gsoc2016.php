<?php
/**
 * Skin made during GSoC 2016
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
class SkinGsoc2016 extends SkinTemplate {
	var $skinname = 'gsoc2016', $stylename = 'gsoc2016',
		$template = 'Gsoc2016Template', $useHeadElement = true;

	/**
	 * @param $out OutputPage
	 */
	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );
		
		$out->addStyle( 'gsoc2016/materialize.css', 'screen');
		$out->addStyle( 'gsoc2016/style.css', 'screen');
	}
}

/**
 * @todo document
 * @ingroup Skins
 */
class Gsoc2016Template extends BaseTemplate {

	/**
	 * Template filter callback for Base skin.
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

    <!-- Navigation -->
    <nav id="navbar">
        <div class="container">
            <!-- Logo -->
            <div>
                <a href="#" data-activates="slide-out" class="right hide-on-large button-collapse"><i class="material-icons">menu</i></a>
                <a class="white-text left" href="<?php echo htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] );?>">
                    <div id="nav-logo"></div>BRL-CAD</a>
            </div>
            <!-- Navigation list -->
            <ul class="right nav-list hide-on-med-and-down">
                <li><a class="waves-effect waves-light " href="/">HOME</a></li>
                <li><a class="waves-effect waves-light " href="/download/">DOWNLOAD</a></li>
                <li><a class="waves-effect waves-light " href="/about/">ABOUT</a></li>
                <li><a class="waves-effect waves-light active" href="<?php echo htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] );?>">DOCUMENTATION</a></li>
                <li><a class="waves-effect waves-light " href="/news/">NEWS</a></li>
                <li><a class="waves-effect waves-light " href="/get-involved/">GET INVOLVED</a></li>
            </ul>
            <!-- Slide out navigation -->
            <ul id="slide-out" class="side-nav">
                <li><a href="/">HOME</a></li>
                <li><a href="/download/">DOWNLOAD</a></li>
                <li><a href="/about/">ABOUT</a></li>
                <li><a href="<?php echo htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] );?>">DOCUMENTATION</a></li>
                <li><a href="/news/">NEWS</a></li>
                <li><a href="/get-involved/">GET INVOLVED</a></li>
            </ul>

        </div>
    </nav>
    <!-- Toolbar -->
    <div class="toolbar">
        <div class="container">
            <ul class="toolbar-tabs">
                <ul>
                    <?php
                        foreach ( $this->data['content_navigation']['namespaces'] as $key => $tab ) {
                            echo $this->makeListItem( $key, $tab );
                        }
                    ?>
                </ul>
                <ul class="right usertabs">
                    <li><a class="dropdown-button waves-effect" data-constrainwidth="false" data-beloworigin="true" data-activates="dropdown-account">Account</a></li>
                    <ul id='dropdown-account' class='dropdown-content'>
                        <?php
                                foreach ( $this->getPersonalTools() as $key => $item ) {
                                    echo $this->makeListItem( $key, $item );
                                }
                            ?>
                    </ul>
                    <li><a class="dropdown-button waves-effect" data-constrainwidth="false" data-beloworigin="true" data-activates="dropdown-tools">Tools</a></li>
                    <ul id='dropdown-tools' class='dropdown-content'>
                        <?php
                                foreach ( $this->getToolbox() as $key => $tbitem ) {
                                    echo $this->makeListItem( $key, $tbitem );
                                }
                            ?>
                    </ul>
                </ul>
                <ul class="right">
                    <?php
                        foreach ( $this->data['content_navigation']['actions'] as $key => $tab ) {
                            echo $this->makeListItem( $key, $tab );
                        }
                    ?>
                </ul>
                <ul class="right">
                    <?php
                        foreach ( $this->data['content_navigation']['views'] as $key => $tab ) {
                            echo $this->makeListItem( $key, $tab );
                        }
                    ?>
                </ul>
                <!-- Search form -->
                <form class="right" action="<?php $this->text( 'wgScript' ); ?>">
                    <input type="hidden" name="title" value="<?php $this->text( 'searchtitle' ) ?>" />
                    <input name="search" placeholder="Search" class="left" type="search" size="10">
                </form>
            </ul>
        </div>
    </div>
    <div class="header">
        <div class="container">
            <h1><?php $this->html( 'title' ); ?></h1>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <?php $this->html( 'bodytext' ) ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="page-footer">
    <div class="container">
        <div class="row">
            <div class="col s12 m4 l4">
                <h5 class="white-text">Connect</h5>
                <a style="margin-bottom: 5px;" href="http://webchat.freenode.net/?channels=#brlcad" class="btn white black-text waves-effect">IRC Channel</a>
                <a class="github-button" href="https://github.com/BRL-CAD" data-style="mega" data-count-href="/BRL-CAD/followers" data-count-api="/users/BRL-CAD#followers" data-count-aria-label="# followers on GitHub" aria-label="Follow @BRL-CAD on GitHub">Follow @BRL-CAD</a><br>
                <a href="https://twitter.com/BRL_CAD" class="twitter-follow-button" data-size="large" data-show-count="false">Follow @BRL_CAD</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script><br>
                <iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2FBRL-CAD-387112738872%2F&width=73&layout=button_count&action=like&show_faces=false&share=false&height=21&appId" width="100" height="21" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe><br>
            </div>
            <div class="col s12 m4 l4">
                <h5 class="white-text">Useful links</h5>
                <ul class="footer-links">
                <li><a href="http://brlcad.org/wiki/Overview">Getting started</a></li>
                <li><a href="http://brlcad.org/wiki/FAQ">FAQ</a></li>
                <li><a href="https://github.com/BRL-CAD">GitHub</a></li>
                <li><a href="https://sourceforge.net/projects/brlcad/">SourceForge</a></li>
                <li><a href="https://sourceforge.net/projects/brlcad/support">Support</a></li>
                </ul>
            </div>
            <div class="col s12 m4 l4">
                <h5 class="white-text">Contribute</h5>
                <ul class="footer-links">
                <li><a href="https://www.flossmanuals.net/contributors-guide-to-brl-cad/">Contributor's guide</a></li>
                <li><a href="http://brlcad.org/BRL-CAD_Priorities.png">BRL-CAD Priorities</a></li>
                <li><a href="http://brlcad.org/~sean/ideas.html">Development Ideas</a></li>
                <li><a href="http://brlcad.org/wiki/Contributor_Quickies">Contributors Quickes</a></li>
                <li><a href="http://brlcad.org/wiki/Google_Summer_of_Code">Google Summer of Code</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright center">
        <div class="container">
            BRL-CAD © <?php echo date('Y'); ?> All trademarks referenced in here are the properties of their respective owners. This site is not sponsored, endorsed, or run by the U.S. Government.
        </div>
    </div>
</footer>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->getSkin()->getSkinStylePath( 'brlcad.js'); ?>"></script>


    <?php
		
	}
}
