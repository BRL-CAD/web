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
            <div class="left">
                <a href="#" data-activates="slide-out" class="left hide-on-large button-collapse"><i class="material-icons">menu</i></a>
                <a class="white-text" href="<?php echo htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] );?>">
                    <div id="nav-logo"></div>BRL-CAD</a>
            </div>
            <!-- Navigation list -->
            <ul class="right nav-list hide-on-med-and-down">
                <li><a class="waves-effect waves-light " href="http://live.esde.name/">HOME</a></li>
                <li><a class="waves-effect waves-light " href="http://live.esde.name/download/">DOWNLOAD</a></li>
                <li><a class="waves-effect waves-light " href="http://live.esde.name/about/">ABOUT</a></li>
                <li><a class="waves-effect waves-light active" href="<?php echo htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] );?>">DOCUMENTATION</a></li>
                <li><a class="waves-effect waves-light " href="http://live.esde.name/news/">NEWS</a></li>
                <li><a class="waves-effect waves-light " href="http://live.esde.name/get-involved/">GET INVOLVED</a></li>
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
                <div class="col l2 s6">
                    <ul>
                        <li><a class="grey-text text-lighten-3" href="/">Home</a></li>
                        <li><a class="grey-text text-lighten-3" href="/about/">About</a></li>
                        <li><a class="grey-text text-lighten-3" href="/download/">Download</a></li>
                        <li><a class="grey-text text-lighten-3" href="/news/">News</a></li>
                    </ul>
                </div>
                <div class="col l2 s6">
                    <ul>
                        <li><a class="grey-text text-lighten-3" href="/get-involved/">Get involved</a></li>
                        <li><a class="grey-text text-lighten-3" href="http://brlcad.org/wiki/Documentation">Documentation</a></li>
                        <li><a class="grey-text text-lighten-3" href="#">OGV</a></li>
                    </ul>
                </div>
                <div class="col m12 l4 right social">
                    <a href="https://twitter.com/brl_cad"><img src="<?php echo $this->getSkin()->getSkinStylePath( 'twitter.png'); ?>" alt=""></a>
                    <a href="https://www.facebook.com/BRL-CAD-387112738872/"><img src="<?php echo $this->getSkin()->getSkinStylePath( 'facebook.png'); ?>" alt=""></a>
                    <a href="https://plus.google.com/s/brl%20-%20cad"><img src="<?php echo $this->getSkin()->getSkinStylePath( 'google.png'); ?>" alt=""></a>
                    <a href="https://www.youtube.com/results?search_query=brl+-+cad"><img src="<?php echo $this->getSkin()->getSkinStylePath( 'youtube.png'); ?>" alt=""></a>
                    <a href="https://www.linkedin.com/in/brlcad"><img src="<?php echo $this->getSkin()->getSkinStylePath( 'linkedin.png'); ?>" alt=""></a>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                BRL-CAD © 2016 All trademarks referenced in here are the properties of their respective owners. This site is not sponsored, endorsed, or run by the U.S. Government.
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