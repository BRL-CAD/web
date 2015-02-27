<?php
/**
 * Template Name: Documentation Template
 * Description: The template for documentation.
 *
 * @package brlcad
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="row">

				<?php while ( have_posts() ) : the_post(); ?>

					<!-- sidebar menu -->
					<div id="sidebar" class="columns large-3">
						<aside class="menu">
							<?php wp_nav_menu( array( 'theme_location' => 'sidebar' ) ); ?>
						</aside>
					</div>

					<!-- article content -->
					<div class="columns large-9">
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						    <?php the_content(); ?>
						</article>
					</div>

				<?php endwhile; // end of the loop. ?>

			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
