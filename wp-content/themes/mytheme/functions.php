<?php
require_once('bs4navwalker.php');
 //Category Description in html formet 
foreach ( array( 'pre_term_description' ) as $filter ) { 
    remove_filter( $filter, 'wp_filter_kses' ); 
} 
foreach ( array( 'term_description' ) as $filter ) { 
    remove_filter( $filter, 'wp_kses_data' ); 
}


add_theme_support( 'post-thumbnails' );

add_theme_support( 'custom-logo', array(
		'height'      => 240,
		'width'       => 240,
		'flex-height' => true,
		'flex-width' => true,
	) );

//Widget function
function mohit_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'mohit' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'mohit' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Header Number & Mail', 'mohit' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'mohit' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Header Social Media', 'mohit' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'mohit' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'mohit_widgets_init' );
/* Slider  Post Type */
function slider_post_register() {
    $labels = array(
        'name' => _x('Slider', 'post type general name'),
        'singular_name' => _x('Slider Item', 'post type singular name'),
        'add_new' => _x('Add New', 'Slider item'),
        'add_new_item' => __('Add New Slider'),
        'edit_item' => __('Edit Slider'),
        'new_item' => __('New Slider Item'),
        'view_item' => __('View Slider Item'),
        'search_items' => __('Search Slider Items'),
        'not_found' =>  __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'menu_icon'   => 'dashicons-images-alt',
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => 20,
        'supports' => array('title','editor','thumbnail')
    ); 
    register_post_type( 'slider' , $args );
}
add_action('init', 'slider_post_register');

function give_profile_name(){
    $user=wp_get_current_user();
    $name=$user->user_nicename; 
    return $name;
}

add_shortcode('profile_name', 'give_profile_name');

add_filter( 'wp_nav_menu_objects', 'my_dynamic_menu_items' );
function my_dynamic_menu_items( $menu_items ) {
    foreach ( $menu_items as $menu_item ) {
        if ( '#profile_name#' == $menu_item->title ) {
            global $shortcode_tags;
            if ( isset( $shortcode_tags['profile_name'] ) ) {
                // Or do_shortcode(), if you must.
                $menu_item->title = call_user_func( $shortcode_tags['profile_name'] );
            }    
        }
    }
    return $menu_items;
} 

/*
For APIS.
*/ 

add_action('rest_api_init', function () {
  register_rest_route( 'apidemos/v1', '',array(
                'methods'  => 'GET',
                'callback' => 'get_latest_posts_by_category'
      ));
});


/*
Text Editer Change
*/
add_filter('use_block_editor_for_post', '__return_false', 10);


/* 
Logout Redirection
*/ 
add_action( 'wp_logout', 'redirect_after_logout');
function redirect_after_logout(){
  wp_redirect( home_url('login') );
  exit();
}


function get_data() {
        
        echo  "test";
        wp_die();  //die();
    }

add_action( 'wp_ajax_nopriv_get_data', 'get_data' );
add_action( 'wp_ajax_get_data', 'get_data' );
