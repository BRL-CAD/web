<?php
/**
 * Template Name: Center Template
 * Description: The template for register and login pages.
 *
 * @package brlcad
 */
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="row">

				<?php while ( have_posts() ) : the_post(); ?>

					<!-- main content -->
					<div class="columns large-4 large-centered">
						
						<?php the_content(); ?>

					</div>

				<?php endwhile; // end of the loop. ?>

			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>