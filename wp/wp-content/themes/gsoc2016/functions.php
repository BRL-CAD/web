<?php
function my_function_admin_bar(){ return false; }
add_filter( 'show_admin_bar' , 'my_function_admin_bar');

function my_excerpt_length($length) {
	return 15;
}
add_filter('excerpt_length', 'my_excerpt_length');
function wpdocs_excerpt_more( $more ) {
    return ' ...';
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );


// Theme activation
if (isset($_GET['activated']) && is_admin()){
        
        function init_page($title, $template)
        {
                 $page = array(
                    'post_type' => 'page',
                    'post_title' => $title,
                    'post_content' => '',
                    'post_status' => 'publish',
                    'post_author' => 1,
                );
                //Check if page is already created
                $page_check = get_page_by_title($title);
                if(!isset($page_check->ID)){
                    $new_page_id = wp_insert_post($page);
                }
                //Change template anyway
                update_post_meta($new_page_id, '_wp_page_template', $template);   
        }
        
        init_page("Home","page-front.php");
        init_page("About","about.php");
        init_page("Get Involved","get-involved.php");
        init_page("Download","download.php");
        init_page("News","");
        
        //Make Home page display on front page
        $homeSet = get_page_by_title( 'Home' );
        $newsSet = get_page_by_title( 'News' );
        update_option( 'page_on_front', $homeSet->ID );
        update_option( 'page_for_posts', $newsSet->ID );
        update_option( 'show_on_front', 'page' );
        
        //Update permalinks
        update_option( 'permalink_structure ', "/news/%postname%/" );
        
        //Update posts per page
        update_option( 'posts_per_page', "6");
}
?>