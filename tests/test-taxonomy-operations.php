<?php

class Test_Taxonomy_Operations extends WP_UnitTestCase {

	public function test_can_create_activity_term() {
		$term = wp_insert_term( 'Swimming', 'activity' );
		$this->assertIsArray( $term );
		$this->assertArrayHasKey( 'term_id', $term );
		
		// Cleanup
		wp_delete_term( $term['term_id'], 'activity' );
	}

	public function test_can_assign_multiple_taxonomies_to_park() {
		$activity = wp_insert_term( 'Camping', 'activity' );
		$facility = wp_insert_term( 'Restrooms', 'facility' );
		$location = wp_insert_term( 'Fraser Valley', 'location' );

		$park_id = wp_insert_post([
			'post_type' => 'park',
			'post_title' => 'Multi-taxonomy Park',
			'post_status' => 'publish',
		]);

		wp_set_object_terms( $park_id, $activity['term_id'], 'activity' );
		wp_set_object_terms( $park_id, $facility['term_id'], 'facility' );
		wp_set_object_terms( $park_id, $location['term_id'], 'location' );

		$park_activities = wp_get_object_terms( $park_id, 'activity' );
		$park_facilities = wp_get_object_terms( $park_id, 'facility' );
		$park_locations = wp_get_object_terms( $park_id, 'location' );

		$this->assertCount( 1, $park_activities );
		$this->assertCount( 1, $park_facilities );
		$this->assertCount( 1, $park_locations );

		// Cleanup
		wp_delete_post( $park_id, true );
		wp_delete_term( $activity['term_id'], 'activity' );
		wp_delete_term( $facility['term_id'], 'facility' );
		wp_delete_term( $location['term_id'], 'location' );
	}

	public function test_hierarchical_taxonomy_supports_parent_child() {
		$parent = wp_insert_term( 'Water Sports', 'activity' );
		$child = wp_insert_term( 'Kayaking', 'activity', [
			'parent' => $parent['term_id'],
		]);

		$child_term = get_term( $child['term_id'], 'activity' );
		$this->assertEquals( $parent['term_id'], $child_term->parent );

		// Cleanup
		wp_delete_term( $child['term_id'], 'activity' );
		wp_delete_term( $parent['term_id'], 'activity' );
	}

	public function test_has_camping_helper() {
		$park_id = wp_insert_post([
			'post_type' => 'park',
			'post_title' => 'Test Camping Park',
			'post_status' => 'publish',
		]);
		wp_set_object_terms( $park_id, 'camping', 'park_type' );
		$this->assertTrue( my_parks_has_camping( $park_id ) );
		wp_delete_post( $park_id, true );
	}
}
