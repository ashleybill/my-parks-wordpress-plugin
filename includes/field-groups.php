<?php
/**
 * Register SCF Field Groups
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function my_parks_register_field_groups() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	// Park Configuration Field Group
	acf_add_local_field_group( array(
		'key' => 'group_park_configuration',
		'title' => 'Park Configuration',
		'menu_order' => 0,
		'active' => true,
		'show_in_rest' => false,
		'fields' => array(
			array(
				'key' => 'field_tab_content',
				'label' => 'Content',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
			),
			array(
				'key' => 'field_about_short',
				'label' => 'About (Short)',
				'name' => 'about_short',
				'type' => 'wysiwyg',
				'instructions' => 'Short description to display next to the gallery',
				'toolbar' => 'full',
				'media_upload' => 0,
			),
			array(
				'key' => 'field_about_continued',
				'label' => 'About (Continued)',
				'name' => 'about_continued',
				'type' => 'wysiwyg',
				'instructions' => 'Additional park information',
				'toolbar' => 'full',
				'media_upload' => 0,
			),
			array(
				'key' => 'field_visitor_services',
				'label' => 'Visitor Services',
				'name' => 'visitor_services',
				'type' => 'wysiwyg',
				'toolbar' => 'full',
				'media_upload' => 0,
			),
			array(
				'key' => 'field_gallery',
				'label' => 'Gallery',
				'name' => 'gallery',
				'type' => 'gallery',
			),
			array(
				'key' => 'field_tab_advisories',
				'label' => 'Advisories',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
			),
			array(
				'key' => 'field_park_advisories',
				'label' => 'Advisories',
				'name' => 'park_advisories',
				'type' => 'repeater',
				'layout' => 'block',
				'button_label' => 'Add Advisory',
				'sub_fields' => array(
					array(
						'key' => 'field_advisory_title',
						'label' => 'Title',
						'name' => 'title',
						'type' => 'text',
					),
					array(
						'key' => 'field_advisory_description',
						'label' => 'Description',
						'name' => 'description',
						'type' => 'wysiwyg',
						'toolbar' => 'basic',
						'media_upload' => 0,
					),
				),
			),
			array(
				'key' => 'field_tab_dates_rates',
				'label' => 'Dates & Rates',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
			),
			array(
				'key' => 'field_operational_dates',
				'label' => 'Operational Dates',
				'name' => 'operational_dates',
				'type' => 'repeater',
				'layout' => 'block',
				'button_label' => 'Add Operational Date',
				'sub_fields' => array(
					array(
						'key' => 'field_facilityservicearea',
						'label' => 'Facility/Service Area',
						'name' => 'facilityservicearea',
						'type' => 'text',
					),
					array(
						'key' => 'field_from',
						'label' => 'From',
						'name' => 'from',
						'type' => 'date_picker',
						'display_format' => 'F j',
						'return_format' => 'F j',
					),
					array(
						'key' => 'field_to',
						'label' => 'To',
						'name' => 'to',
						'type' => 'date_picker',
						'display_format' => 'F j',
						'return_format' => 'F j',
					),
					array(
						'key' => 'field_details',
						'label' => 'Details',
						'name' => 'details',
						'type' => 'wysiwyg',
						'toolbar' => 'basic',
						'media_upload' => 0,
					),
				),
			),
			array(
				'key' => 'field_rates',
				'label' => 'Rates',
				'name' => 'rates',
				'type' => 'repeater',
				'layout' => 'block',
				'button_label' => 'Add Rate',
				'sub_fields' => array(
					array(
						'key' => 'field_fee_type',
						'label' => 'Fee Type',
						'name' => 'fee_type',
						'type' => 'text',
					),
					array(
						'key' => 'field_breakdown',
						'label' => 'Breakdown',
						'name' => 'breakdown',
						'type' => 'repeater',
						'layout' => 'table',
						'button_label' => 'Add Rate',
						'sub_fields' => array(
							array(
								'key' => 'field_rate_type',
								'label' => 'Rate Type',
								'name' => 'rate_type',
								'type' => 'text',
							),
							array(
								'key' => 'field_rate_amount',
								'label' => 'Rate Amount',
								'name' => 'rate_amount',
								'type' => 'text',
							),
						),
					),
				),
			),
			array(
				'key' => 'field_tab_maps',
				'label' => 'Maps',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
			),
			array(
				'key' => 'field_park_maps',
				'label' => 'Park Maps',
				'name' => 'park_maps',
				'type' => 'repeater',
				'layout' => 'block',
				'button_label' => 'Add Map',
				'instructions' => 'Add downloadable park maps (e.g. campground map, trail map, cabin map). Each entry needs a label and a file.',
				'sub_fields' => array(
					array(
						'key' => 'field_park_map_label',
						'label' => 'Label',
						'name' => 'label',
						'type' => 'text',
						'instructions' => 'Display name for this map (e.g. "Campground Map", "Trail Map")',
						'required' => 1,
					),
					array(
						'key' => 'field_park_map_file',
						'label' => 'Map File',
						'name' => 'file',
						'type' => 'file',
						'instructions' => 'Upload or select a PDF or image file',
						'return_format' => 'array',
						'library' => 'all',
						'required' => 1,
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'park',
				),
			),
		),
	) );

	// Coordinates Field Group
	acf_add_local_field_group( array(
		'key' => 'group_park_coordinates',
		'title' => 'Park Location',
		'menu_order' => 1,
		'fields' => array(
			array(
				'key' => 'field_coordinates',
				'label' => 'Coordinates',
				'name' => 'coordinates',
				'type' => 'group',
				'sub_fields' => array(
					array(
						'key' => 'field_latitude',
						'label' => 'Latitude',
						'name' => 'latitude',
						'type' => 'number',
						'step' => 'any',
					),
					array(
						'key' => 'field_longitude',
						'label' => 'Longitude',
						'name' => 'longitude',
						'type' => 'number',
						'step' => 'any',
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'park',
				),
			),
		),
	) );

	// Taxonomy Icon Field Group (shared by activities and facilities)
	acf_add_local_field_group( array(
		'key' => 'group_taxonomy_logo',
		'title' => 'Taxonomy Configuration',
		'fields' => array(
			array(
				'key' => 'field_taxonomy_icon',
				'label' => 'Icon',
				'name' => 'icon',
				'type' => 'image',
				'return_format' => 'array',
				'preview_size' => 'thumbnail',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => 'activity',
				),
			),
			array(
				array(
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => 'facility',
				),
			),
		),
	) );
}
add_action( 'acf/init', 'my_parks_register_field_groups' );

function my_parks_migrate_field_keys() {
	if ( get_option( 'my_parks_field_keys_migrated' ) ) {
		return;
	}
	
	if ( ! function_exists( 'acf_get_fields' ) ) {
		return;
	}
	
	global $wpdb;
	
	// Migrate park field group
	$fields = acf_get_fields( 'group_park_configuration' );
	if ( $fields ) {
		foreach ( $fields as $field ) {
			my_parks_migrate_field_recursive( $field, $wpdb );
		}
	}
	
	// Migrate taxonomy field group
	$tax_fields = acf_get_fields( 'group_taxonomy_logo' );
	if ( $tax_fields ) {
		foreach ( $tax_fields as $field ) {
			my_parks_migrate_taxonomy_field( $field, $wpdb );
		}
	}
	
	update_option( 'my_parks_field_keys_migrated', true );
}

function my_parks_migrate_post_content_to_acf() {
	if ( get_option( 'my_parks_content_migrated' ) ) {
		return;
	}
	
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}
	
	global $wpdb;
	
	// Get all parks with post_content
	$parks = $wpdb->get_results(
		"SELECT ID, post_content FROM {$wpdb->posts} 
		WHERE post_type = 'park' AND post_content != ''"
	);
	
	foreach ( $parks as $park ) {
		// Only migrate if about_short is empty
		if ( ! get_field( 'about_short', $park->ID ) ) {
			update_field( 'about_short', $park->post_content, $park->ID );
		}
	}
	
	update_option( 'my_parks_content_migrated', true );
}

function my_parks_migrate_field_recursive( $field, $wpdb ) {
	$field_name = $field['name'];
	$field_key = $field['key'];
	
	// Find any meta entries with this field name that have a different key
	$old_keys = $wpdb->get_col( $wpdb->prepare(
		"SELECT DISTINCT meta_value FROM {$wpdb->postmeta} 
		WHERE meta_key LIKE %s AND meta_value LIKE 'field_%%' AND meta_value != %s",
		'_' . $field_name,
		$field_key
	) );
	
	foreach ( $old_keys as $old_key ) {
		$wpdb->query( $wpdb->prepare(
			"UPDATE {$wpdb->postmeta} SET meta_value = %s WHERE meta_value = %s",
			$field_key,
			$old_key
		) );
	}
	
	// Recursively handle sub_fields for repeaters
	if ( ! empty( $field['sub_fields'] ) ) {
		foreach ( $field['sub_fields'] as $sub_field ) {
			my_parks_migrate_field_recursive( $sub_field, $wpdb );
		}
	}
}

function my_parks_migrate_taxonomy_field( $field, $wpdb ) {
	$field_name = $field['name'];
	$field_key = $field['key'];
	
	$old_keys = $wpdb->get_col( $wpdb->prepare(
		"SELECT DISTINCT meta_value FROM {$wpdb->termmeta} 
		WHERE meta_key LIKE %s AND meta_value LIKE 'field_%%' AND meta_value != %s",
		'_' . $field_name,
		$field_key
	) );
	
	foreach ( $old_keys as $old_key ) {
		$wpdb->query( $wpdb->prepare(
			"UPDATE {$wpdb->termmeta} SET meta_value = %s WHERE meta_value = %s",
			$field_key,
			$old_key
		) );
	}
}
add_action( 'acf/init', 'my_parks_migrate_field_keys', 20 );
add_action( 'acf/init', 'my_parks_migrate_post_content_to_acf', 30 );
add_action( 'acf/init', 'my_parks_migrate_visitor_services_to_wysiwyg', 40 );
add_action( 'acf/init', 'my_parks_migrate_operational_dates_to_wysiwyg', 50 );
add_action( 'acf/init', 'my_parks_migrate_advisories_to_wysiwyg', 60 );

function my_parks_migrate_visitor_services_to_wysiwyg() {
	if ( get_option( 'my_parks_visitor_services_migrated' ) ) {
		return;
	}
	
	if ( ! function_exists( 'get_field' ) || ! function_exists( 'update_field' ) ) {
		return;
	}
	
	global $wpdb;
	
	// Get all parks with visitor_services content
	$parks = $wpdb->get_results(
		"SELECT p.ID FROM {$wpdb->posts} p 
		INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id 
		WHERE p.post_type = 'park' AND pm.meta_key = 'visitor_services' AND pm.meta_value != ''"
	);
	
	foreach ( $parks as $park ) {
		$current_content = get_field( 'visitor_services', $park->ID );
		if ( $current_content && is_string( $current_content ) ) {
			// Convert line breaks to HTML paragraphs for WYSIWYG
			$html_content = wpautop( $current_content );
			update_field( 'visitor_services', $html_content, $park->ID );
		}
	}
	
	update_option( 'my_parks_visitor_services_migrated', true );
}

function my_parks_migrate_operational_dates_to_wysiwyg() {
	if ( get_option( 'my_parks_operational_dates_migrated' ) ) {
		return;
	}
	
	if ( ! function_exists( 'get_field' ) || ! function_exists( 'update_field' ) ) {
		return;
	}
	
	global $wpdb;
	
	// Get all parks with operational_dates content
	$parks = $wpdb->get_results(
		"SELECT p.ID FROM {$wpdb->posts} p 
		INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id 
		WHERE p.post_type = 'park' AND pm.meta_key = 'operational_dates' AND pm.meta_value != ''"
	);
	
	foreach ( $parks as $park ) {
		$operational_dates = get_field( 'operational_dates', $park->ID );
		if ( $operational_dates && is_array( $operational_dates ) ) {
			$updated = false;
			foreach ( $operational_dates as $index => $date ) {
				if ( isset( $date['details'] ) && is_string( $date['details'] ) && ! empty( $date['details'] ) ) {
					// Convert line breaks to HTML paragraphs for WYSIWYG
					$html_content = wpautop( $date['details'] );
					$operational_dates[$index]['details'] = $html_content;
					$updated = true;
				}
			}
			if ( $updated ) {
				update_field( 'operational_dates', $operational_dates, $park->ID );
			}
		}
	}
	
	update_option( 'my_parks_operational_dates_migrated', true );
}

function my_parks_migrate_advisories_to_wysiwyg() {
	if ( get_option( 'my_parks_advisories_migrated' ) ) {
		return;
	}
	
	if ( ! function_exists( 'get_field' ) || ! function_exists( 'update_field' ) ) {
		return;
	}
	
	global $wpdb;
	
	// Get all parks with park_advisories content
	$parks = $wpdb->get_results(
		"SELECT p.ID FROM {$wpdb->posts} p 
		INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id 
		WHERE p.post_type = 'park' AND pm.meta_key = 'park_advisories' AND pm.meta_value != ''"
	);
	
	foreach ( $parks as $park ) {
		$advisories = get_field( 'park_advisories', $park->ID );
		if ( $advisories && is_array( $advisories ) ) {
			$updated = false;
			foreach ( $advisories as $index => $advisory ) {
				if ( isset( $advisory['description'] ) && is_string( $advisory['description'] ) && ! empty( $advisory['description'] ) ) {
					// Convert line breaks to HTML paragraphs for WYSIWYG
					$html_content = wpautop( $advisory['description'] );
					$advisories[$index]['description'] = $html_content;
					$updated = true;
				}
			}
			if ( $updated ) {
				update_field( 'park_advisories', $advisories, $park->ID );
			}
		}
	}
	
	update_option( 'my_parks_advisories_migrated', true );
}