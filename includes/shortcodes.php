<?php
/**
 * Register Shortcodes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Park Map Shortcode
function park_map_shortcode($atts) {
	$atts = shortcode_atts(array(
		'text' => ''
	), $atts);
	
	$coords = get_field('coordinates');
	if ($coords && $coords['latitude'] && $coords['longitude']) {
		$lat = $coords['latitude'];
		$lng = $coords['longitude'];
		$text = $atts['text'] ? '<span class="park-map-text">' . esc_html($atts['text']) . '</span>' : '';
		
		return '<a href="https://maps.google.com/maps?q=' . $lat . ',' . $lng . '" target="_blank" class="park-map-link" aria-label="View on Google Maps">' . 
			$text .
			'<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="currentColor">' . 
			'<path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>' . 
			'</svg>' . 
			'</a>';
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
