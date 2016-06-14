<?php get_header(); ?>

<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="header">
        <div class="container">
            <h1><?php the_title(); ?></h1>
        </div>
    </div>
    <div class="content">
        <div class="container">
            <?php the_content(); ?>
        </div>
    </div>
    <?php endwhile;?>
    <?php else : ?>
    <?php endif; ?>

<?php get_footer(); ?>