<?php get_header(); ?>

<div class="header">
	<div class="container">
		<i class="material-icons">rss_feed</i>
		<h1>News</h1>
	</div>
</div>

<div class="content">
	<div class="container">
		<div class="row">
			<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
			<div class="col m6 s12">
				<div class="card news-card">
					<div class="card-content">
						<span class="card-title"><?php the_title(); ?></span>
						<span class="card-date right"><?php the_time( 'j M y' ); ?></span>
						<p>
							<?php the_excerpt(); ?>
						</p>
					</div>
					<div class="card-action right-align">
						<a class="pink-text" href="<?php the_permalink(); ?>">Read more</a>
					</div>
				</div>
			</div>
			<?php endwhile;?>
			<?php else : ?>
			<?php endif; ?>
			
			<div class="col m12 center">
				<div class="nav-right right"><?php next_posts_link( 'Older posts' ); ?></div>
				<div class="nav-left left"><?php previous_posts_link( 'Newer posts' ); ?></div>
			</div>
		</div>
	</div>
</div>


<?php get_footer(); ?>