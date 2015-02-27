<?php
/**
 * Template Name: Sidebar Template
 * Description: The template for sidebar page.
 *
 * @package brlcad
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="row">

				<?php while ( have_posts() ) : the_post(); ?>

					<!-- article content -->
					<div class="columns large-9">
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						    <?php the_content(); ?>
						</article>
						
						<?php
							// If comments are open or we have at least one comment, load up the comment template
							if ( comments_open() || '0' != get_comments_number() ) :
								comments_template();
							endif;
						?>
					</div>

					<!-- sidebar menu -->
					<div id="sidebar" class="columns large-3">
						<aside class="sidebar">
							<?php 
								if (is_active_sidebar('sidebar-1')){
									dynamic_sidebar('sidebar-1');
								}
							?>
						</aside>
					</div>

				<?php endwhile; // end of the loop. ?>

			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
