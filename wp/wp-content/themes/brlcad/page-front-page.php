<?php
/**
 * The Template for front page
 *
 * @package brlcad
 */

get_header(); ?>
	<header id="masthead">

		<div class="row">
			<!-- sign in -->
			<div class="columns large-4">
				<?php 
				if ( !is_user_logged_in() ) { // is not logged  in
					echo do_shortcode('[bbp-login]');
					echo '<div><a href="' .  get_page_link(1965) . '" id="bpp-lost-pass">Forgot password</a></div>' ;
					echo '<div><a href="' . get_page_link(1962) . '" id="bpp-registration">Sign up</a></div>';
				} else { // is logged in
					echo "<p class='logged-in'>Hi " . $current_user->user_login . ", you're logged in! Feel free to browse.</p>";
				}
				?>

			</div>
			<!-- site-branding -->
			<div class="site-branding columns large-7 ">
				<h1 id="site-title"><?php bloginfo( 'name' ); ?></h1>
				<h2 id="site-tagline"><?php bloginfo( 'description' ); ?></h2>
				<p id="site-description"><?php the_field('site_description'); ?></p>
				<button id="download-button" class="button"><a href="<?php the_field('front_page_description_download'); ?>" target="_blank">Download a .deb package</a></button>
			</div>
		</div>

	</header>

	<main id="main" class="site-main" role="main">
	
		<h1 id="about-title" class="text-center"><?php the_field('about_title'); ?></h2>
		
		<?php 

		$num = 1;

		$get_content = get_field('about_section_'.$num.'_content');

		while($get_content) {

			if($num % 2 == 1) { // it's an odd section
				$odd = true; 
			}elseif($num % 2 == 0) { // it's an even section
				$odd = false;
			}

			$html = "";
			$html.='<section class="row full-height about">';
				if ($odd) { // is odd
					$html.='<div class="columns full-height large-6 to equalize">';
					$html.='<div class="ti">';
					$html.= get_field('about_section_' . $num . '_content');
					$html.='</div>';
					$html.='</div>';
				} else {
					$html.='<div class="columns full-height large-6 to text-center equalize">';
					$html.='<div class="about-images">';
					if(get_field('about_section_' . $num . '_image_2')){
						$html.= '<img src="' . get_field('about_section_' . $num . '_image_1') . '" class="about-first" />';
						$html.= '<img src="' . get_field('about_section_' . $num . '_image_2') . '" class="about-last" />';
					} else {
						$html.= '<img src="' . get_field('about_section_' . $num . '_image_1') . '" />';
					}
					$html.='</div>';
					$html.='</div>';							
				}
				if ($odd) { // is not odd
					$html.='<div class="columns full-height large-6 to text-center equalize">';
					$html.='<div class=" about-images">';
					if(get_field('about_section_' . $num . '_image_2')){
						$html.= '<img src="' . get_field('about_section_' . $num . '_image_1') . '" class="about-first" />';
						$html.= '<img src="' . get_field('about_section_' . $num . '_image_2') . '" class="about-last" />';
					} else {
						$html.= '<img src="' . get_field('about_section_' . $num . '_image_1') . '" />';
					}
					$html.='</div>';	
					$html.='</div>';							
				} else {
					$html.='<div class="columns full-height large-6 to equalize">';
					$html.='<div class="ti">';
					$html.= get_field('about_section_' . $num . '_content');
					$html.='</div>';	
					$html.='</div>';
				}

			$html.='</section>';

			echo $html;

			$num++;
			$get_content = get_field('about_section_' . $num . '_content');



		}


		?>

	</main><!-- #main -->

<?php get_footer(); ?>
