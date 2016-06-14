<?php get_header(); ?>

<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="header">
		<div class="container">
			<i class="material-icons">rss_feed</i>
			<h1>News</h1>
		</div>
	</div>
	<div class="content news-item">
		<div class="container">
			<h3><?php the_title(); ?></h3>
			<span class="date"><?php the_time( 'j M y' ); ?></span>
			<p>
				<?php the_content(); ?>
			</p>
		</div>
	</div>
	<?php endwhile;?>
	<?php else : ?>
	<?php endif; ?>

	<?php get_footer(); ?>