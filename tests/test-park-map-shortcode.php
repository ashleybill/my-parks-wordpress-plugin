<?php

class Test_Park_Map_Shortcode extends WP_UnitTestCase {

	public function setUp(): void {
		parent::setUp();
		
		// Create a test park post
		$this->park_id = wp_insert_post( array(
			'post_type' => 'park',
			'post_title' => 'Test Park',
			'post_status' => 'publish',
		) );
		
		// Mock get_field function
		if ( ! function_exists( 'get_field' ) ) {
			function get_field( $field, $post_id = null ) {
				return get_post_meta( $post_id ?: get_the_ID(), $field, true );
			}
		}
		
		// Register the shortcodes
		if ( ! shortcode_exists( 'park_map' ) ) {
			add_shortcode( 'park_map', 'park_map_shortcode' );
		}
		if ( ! shortcode_exists( 'park_embed_map' ) ) {
			add_shortcode( 'park_embed_map', 'park_embed_map_shortcode' );
		}
	}

	public function test_shortcode_with_coordinates() {
		// Set up coordinates using post meta
		update_post_meta( $this->park_id, 'coordinates', array(
			'latitude' => 40.7128,
			'longitude' => -74.0060
		) );
		
		// Set global post
		global $post;
		$post = get_post( $this->park_id );
		setup_postdata( $post );
		
		$output = do_shortcode( '[park_map]' );
		
		$this->assertStringContainsString( 'https://maps.google.com/maps?q=40.7128,-74.006', $output );
		$this->assertStringContainsString( 'target="_blank"', $output );
		$this->assertStringContainsString( '<svg', $output );
		$this->assertStringContainsString( 'aria-label="View on Google Maps"', $output );
		$this->assertStringContainsString( 'park-map-link', $output );
		
		wp_reset_postdata();
	}

	public function test_shortcode_without_coordinates() {
		global $post;
		$post = get_post( $this->park_id );
		setup_postdata( $post );
		
		$output = do_shortcode( '[park_map]' );
		
		$this->assertEmpty( $output );
		
		wp_reset_postdata();
	}

	public function test_shortcode_with_partial_coordinates() {
		// Set up only latitude using post meta
		update_post_meta( $this->park_id, 'coordinates', array(
			'latitude' => 40.7128,
			'longitude' => ''
		) );
		
		global $post;
		$post = get_post( $this->park_id );
		setup_postdata( $post );
		
		$output = do_shortcode( '[park_map]' );
		
		$this->assertEmpty( $output );
		
		wp_reset_postdata();
	}

	public function test_embed_shortcode_with_coordinates() {
		// Set up coordinates using post meta
		update_post_meta( $this->park_id, 'coordinates', array(
			'latitude' => 40.7128,
			'longitude' => -74.0060
		) );
		
		// Set global post
		global $post;
		$post = get_post( $this->park_id );
		setup_postdata( $post );
		
		$output = do_shortcode( '[park_embed_map]' );
		
		$this->assertStringContainsString( '<iframe', $output );
		$this->assertStringContainsString( 'maps.google.com/maps?q=40.7128,-74.006', $output );
		$this->assertStringContainsString( 'width="100%"', $output );
		$this->assertStringContainsString( 'height="300"', $output );
		$this->assertStringContainsString( '&z=15', $output );
		
		wp_reset_postdata();
	}

	public function test_embed_shortcode_with_custom_attributes() {
		// Set up coordinates using post meta
		update_post_meta( $this->park_id, 'coordinates', array(
			'latitude' => 40.7128,
			'longitude' => -74.0060
		) );
		
		// Set global post
		global $post;
		$post = get_post( $this->park_id );
		setup_postdata( $post );
		
		$output = do_shortcode( '[park_embed_map width="500px" height="400" zoom="12"]' );
		
		$this->assertStringContainsString( 'width="500px"', $output );
		$this->assertStringContainsString( 'height="400"', $output );
		$this->assertStringContainsString( '&z=12', $output );
		
		wp_reset_postdata();
	}

	public function test_embed_shortcode_without_coordinates() {
		global $post;
		$post = get_post( $this->park_id );
		setup_postdata( $post );
		
		$output = do_shortcode( '[park_embed_map]' );
		
		$this->assertEmpty( $output );
		
		wp_reset_postdata();
	}

	public function test_shortcode_with_custom_text() {
		// Set up coordinates using post meta
		update_post_meta( $this->park_id, 'coordinates', array(
			'latitude' => 40.7128,
			'longitude' => -74.0060
		) );
		
		// Set global post
		global $post;
		$post = get_post( $this->park_id );
		setup_postdata( $post );
		
		$output = do_shortcode( '[park_map text="View on Map"]' );
		
		$this->assertStringContainsString( '<span class="park-map-text">View on Map</span>', $output );
		$this->assertStringContainsString( '<svg', $output );
		$this->assertStringContainsString( 'park-map-link', $output );
		
		wp_reset_postdata();
	}
}
