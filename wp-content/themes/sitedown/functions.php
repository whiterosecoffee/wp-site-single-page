<?php //GLOBAL VARIABLES
global $wpdb;
global $current_user; 	//the current user array holds information about the currently logged in user. 
get_currentuserinfo(); 	//retrieves the current user info.  Required before calling a specific value
						//VALUES - $user_login, $user_ID, $user_email, $user_url, $user_pass (md5 hash), $display_name, $user_identity
//MENUS
add_theme_support('main'); //initiates the menu section under the appearances panel in dashboard
register_nav_menu('main','Main Site Navigation');

//SIDEBAR
if ( function_exists('register_sidebar') )
    register_sidebar();
	
//PARENT SLUG - A small custom variable applied to the content to create a custom class for each page <div id="content" class="the_parent_slug();">
function the_parent_slug() {
	global $post;
	if (
		$post->post_parent == 0) {
		echo $post->post_name;
	}
	else {
		$post_data = get_post($post->post_parent);
		echo $post_data->post_name;
	}
	return;
} 
//THUMNAILS
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 50, 50 ); // default Post Thumbnail dimensions
}
if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'gallery-thumbnail', 50, 50, true );
        add_image_size( 'gallery-featured-image', 1000, 650, true  );
}

//* Remove the edit link
add_filter ( 'edit_post_link' , '__return_false' );?>