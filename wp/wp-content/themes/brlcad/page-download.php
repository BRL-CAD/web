<?php
/**
 * The template used for displaying page content on Download page.
 *
 * @package brlcad
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<div class="row">

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<!-- display description -->
					<?php the_field('download_description') ?>

					<!-- download links -->

					<div class="download-links">
						<ul class="download os">
								<div class="columns large-4 small-6">
									<li class="download-links"><a href="<?php the_field('bsd_download')?>" target="_blank">BSD</a></li> 
								</div>
								<div class="columns large-4 small-6">
									<li class="download-links"><a href="<?php the_field('irix_download')?>" target="_blank">Irix</a></li> 
								</div>
								<div class="columns large-4 small-6">
									<li class="download-links"><a href="<?php the_field('linux_download')?>" target="_blank">Linux</a></li> 
								</div>
								<div class="columns large-4 small-6">
									<li class="download-links"><a href="<?php the_field('mac_download')?>" target="_blank">Mac OS X</a></li> 
								</div>
								<div class="columns large-4 small-6">
									<li class="download-links"><a href="<?php the_field('solaris_download')?>" target="_blank">Solaris</a></li> 
								</div>
								<div class="columns large-4 small-6">
									<li class="download-links"><a href="<?php the_field('windows_dowwnload')?>" target="_blank">Windows</a></li> 
								</div>
						</ul>
						<ul class="download gen">	
							<div class="columns large-3">	
								<li class="download-links"><a href="<?php the_field('external_plugins_download')?>" target="_blank">External Plugins</a></li> 
							</div>
							<div class="columns large-3">
								<li class="download-links"><a href="<?php the_field('runtime_libs_download')?>" target="_blank">Runtime Libs</a></li> 
							</div>
							<div class="columns large-3">
								<li class="download-links"><a href="<?php the_field('source_download')?>" target="_blank">Source</a></li> 
							</div>
							<div class="columns large-3">
								<li class="download-links"><a href="<?php the_field('virtual_machine_download')?>" target="_blank">Virtual Machine</a></li>
							</div>
						</ul>
					</div>

					<?php the_content(); ?>

				</article>

			<?php endwhile; // end of the loop. ?>

		</div>
	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>