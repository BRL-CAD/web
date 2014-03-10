<?php get_header(); ?>
 
    <div id="blog">
        <?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
         
        <div class="post">

 
 
            <div class="entry">
            <?php the_content(); ?>
 
 
 
            </div>
 
        </div>
         
<?php endwhile; ?>
 
    <div class="navigation">
        <?php posts_nav_link(); ?>
    </div>
 
<?php endif; ?>
</div>
 
<?php get_footer(); ?>