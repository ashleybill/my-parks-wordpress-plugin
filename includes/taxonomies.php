<?php
/**
 * Register Custom Taxonomies
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function my_parks_register_taxonomies() {
	register_taxonomy( 'activity', 'park', array(
		'labels' => array(
			'name' => __( 'Activities', 'my-parks' ),
			'singular_name' => __( 'Activity', 'my-parks' ),
			'search_items' => __( 'Search Activities', 'my-parks' ),
			'all_items' => __( 'All Activities', 'my-parks' ),
			'edit_item' => __( 'Edit Activity', 'my-parks' ),
			'update_item' => __( 'Update Activity', 'my-parks' ),
			'add_new_item' => __( 'Add New Activity', 'my-parks' ),
			'new_item_name' => __( 'New Activity Name', 'my-parks' ),
		),
		'hierarchical' => true,
		'show_in_rest' => true,
		'rewrite' => array( 'slug' => 'activities' ),
	) );

	register_taxonomy( 'facility', 'park', array(
		'labels' => array(
			'name' => __( 'Facilities', 'my-parks' ),
			'singular_name' => __( 'Facility', 'my-parks' ),
			'search_items' => __( 'Search Facilities', 'my-parks' ),
			'all_items' => __( 'All Facilities', 'my-parks' ),
			'edit_item' => __( 'Edit Facility', 'my-parks' ),
			'update_item' => __( 'Update Facility', 'my-parks' ),
			'add_new_item' => __( 'Add New Facility', 'my-parks' ),
			'new_item_name' => __( 'New Facility Name', 'my-parks' ),
		),
		'hierarchical' => true,
		'show_in_rest' => true,
		'rewrite' => array( 'slug' => 'facilities' ),
	) );

	register_taxonomy( 'location', 'park', array(
		'labels' => array(
			'name' => __( 'Locations', 'my-parks' ),
			'singular_name' => __( 'Location', 'my-parks' ),
			'search_items' => __( 'Search Locations', 'my-parks' ),
			'all_items' => __( 'All Locations', 'my-parks' ),
			'edit_item' => __( 'Edit Location', 'my-parks' ),
			'update_item' => __( 'Update Location', 'my-parks' ),
			'add_new_item' => __( 'Add New Location', 'my-parks' ),
			'new_item_name' => __( 'New Location Name', 'my-parks' ),
		),
		'hierarchical' => true,
		'show_in_rest' => true,
		'rewrite' => array( 'slug' => 'locations' ),
	) );

	register_taxonomy( 'park_type', 'park', array(
		'labels' => array(
			'name' => __( 'Types', 'my-parks' ),
			'singular_name' => __( 'Type', 'my-parks' ),
			'all_items' => __( 'All Types', 'my-parks' ),
		),
		'hierarchical' => true,
		'show_in_rest' => true,
		'rewrite' => array( 'slug' => 'park-types' ),
	) );
}
add_action( 'init', 'my_parks_register_taxonomies' );

function my_parks_has_camping( $post_id = null ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	return has_term( 'camping', 'park_type', $post_id );
}

function my_parks_has_cabin( $post_id = null ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	return has_term( 'cabin', 'park_type', $post_id );
}
