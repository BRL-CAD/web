<?php get_header() ?>

<?php if (have_posts()) { ?>
	<?php while (have_posts()) : the_post(); ?>
		<?php if ($post->post_type == MAXGALLERIA_LITE_POST_TYPE) { ?>
			<div class="mg-container">
				<h1 class="mg-title"><?php echo the_title() ?></h1>
				<?php echo do_shortcode('[maxgallery id="' . $post->ID . '"]') ?>
			</div>
		<?php } ?>
	<?php endwhile; ?>
<?php } ?>

<?php get_footer() ?>