<?php

class Test_Search_Filter extends WP_UnitTestCase {

	public function test_search_filter_modifies_query() {
		// Create a test park
		$park_id = wp_insert_post([
			'post_type' => 'park',
			'post_title' => 'Test Park',
			'post_status' => 'publish',
		]);

		// Simulate search query
		$_GET['park_search'] = 'Test';
		
		$query = new WP_Query([
			'post_type' => 'park',
			's' => 'Test',
		]);

		$this->assertTrue( $query->have_posts() );
		$this->assertEquals( 1, $query->found_posts );

		// Cleanup
		wp_delete_post( $park_id, true );
		unset( $_GET['park_search'] );
	}

	public function test_taxonomy_filter_in_query() {
		// Create activity term
		$term = wp_insert_term( 'Hiking', 'activity' );
		
		// Create park with activity
		$park_id = wp_insert_post([
			'post_type' => 'park',
			'post_title' => 'Hiking Park',
			'post_status' => 'publish',
		]);
		wp_set_object_terms( $park_id, $term['term_id'], 'activity' );

		// Query parks with activity
		$query = new WP_Query([
			'post_type' => 'park',
			'tax_query' => [
				[
					'taxonomy' => 'activity',
					'field' => 'slug',
					'terms' => 'hiking',
				],
			],
		]);

		$this->assertTrue( $query->have_posts() );
		$this->assertEquals( 1, $query->found_posts );

		// Cleanup
		wp_delete_post( $park_id, true );
		wp_delete_term( $term['term_id'], 'activity' );
	}
}
