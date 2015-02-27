<?php
/**
 * The template for gallery page.
 *
 * @package brlcad
 */

get_header(); ?>
	<div id="content-side">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="row">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || '0' != get_comments_number() ) :
							comments_template();
						endif;
					?>

				<?php endwhile; // end of the loop. ?>

			</div>
		</main><!-- #main -->
	</div><!-- #primary -->
</div>
<?php get_sidebar();?>
<?php get_footer(); ?>
