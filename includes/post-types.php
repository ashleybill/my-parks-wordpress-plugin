<?php
/**
 * Register Custom Post Types
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function my_parks_register_post_types() {
	register_post_type( 'park', array(
		'labels' => array(
			'name' => __( 'Parks', 'my-parks' ),
			'singular_name' => __( 'Park', 'my-parks' ),
			'add_new' => __( 'Add New', 'my-parks' ),
			'add_new_item' => __( 'Add New Park', 'my-parks' ),
			'edit_item' => __( 'Edit Park', 'my-parks' ),
			'new_item' => __( 'New Park', 'my-parks' ),
			'view_item' => __( 'View Park', 'my-parks' ),
			'search_items' => __( 'Search Parks', 'my-parks' ),
			'not_found' => __( 'No parks found', 'my-parks' ),
			'not_found_in_trash' => __( 'No parks found in trash', 'my-parks' ),
		),
		'public' => true,
		'has_archive' => false,
		'show_in_rest' => true,
		'supports' => array( 'title', 'thumbnail', 'excerpt' ),
		'menu_icon' => 'dashicons-palmtree',
		'rewrite' => array( 'slug' => 'parks' ),
	) );
}
add_action( 'init', 'my_parks_register_post_types' );
