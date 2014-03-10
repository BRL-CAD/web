<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package brlcad
 */
?>
	</div><!-- #content -->

	<footer id="site-footer">
		<div class="row">
			<aside id="search" class="widget widget_search">
					<?php get_search_form(); ?>
			</aside>
		</div>
		<?php if(is_active_sidebar('footer-sidebar-left')): ?>
			<div class="row">
				<div class="columns large-4">
					<?php 
						dynamic_sidebar('footer-sidebar-left'); 
					?>
				</div>
				<div class="columns large-4">
					<?php 
						dynamic_sidebar('footer-sidebar-center');
					?>
				</div>
				<div class="columns large-4">
					<?php 
						dynamic_sidebar('footer-sidebar-center');
					?>
				</div>
			</div>
		<?php endif; ?>
	</footer>

	<!-- <footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php do_action( 'brlcad_credits' ); ?>
		</div> 
	</footer>-->

	<footer>
	</footer>
</div>

<?php wp_footer(); ?>

</body>
</html>