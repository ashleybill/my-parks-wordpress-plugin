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
		'fields' => array(
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
						'type' => 'textarea',
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
				'key' => 'field_gallery',
				'label' => 'Gallery',
				'name' => 'gallery',
				'type' => 'gallery',
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
						'type' => 'textarea',
					),
				),
			),
			array(
				'key' => 'field_visitor_services',
				'label' => 'Visitor Services',
				'name' => 'visitor_services',
				'type' => 'textarea',
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

// Park Map Shortcode
function park_map_shortcode() {
	$coords = get_field('coordinates');
	if ($coords && $coords['latitude'] && $coords['longitude']) {
		$lat = $coords['latitude'];
		$lng = $coords['longitude'];
		return '<a href="https://maps.google.com/maps?q=' . $lat . ',' . $lng . '" target="_blank" class="park-map-link">📍 View on Map</a>';
	}
	return '';
}
add_shortcode('park_map', 'park_map_shortcode');
// Embedded Park Map Shortcode
function park_embed_map_shortcode($atts) {
	$atts = shortcode_atts(array(
		'width' => '100%',
		'height' => '300',
		'zoom' => '15'
	), $atts);
	
	$coords = get_field('coordinates');
	if ($coords && $coords['latitude'] && $coords['longitude']) {
		$lat = $coords['latitude'];
		$lng = $coords['longitude'];
		
		return '<iframe 
			width="' . esc_attr($atts['width']) . '" 
			height="' . esc_attr($atts['height']) . '" 
			src="https://maps.google.com/maps?q=' . $lat . ',' . $lng . '&z=' . esc_attr($atts['zoom']) . '&output=embed" 
			frameborder="0" 
			style="border:0;" 
			allowfullscreen>
		</iframe>';
	}
	return '';
}
add_shortcode('park_embed_map', 'park_embed_map_shortcode');