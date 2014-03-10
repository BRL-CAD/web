<?php get_header(); ?>
 
    <div id="blog">
        <?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
         
<?php endwhile; ?>
         
        <?php endif; ?>
    </div> 
<?php get_footer(); ?> 