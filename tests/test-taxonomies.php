<?php

class Test_Taxonomies extends WP_UnitTestCase {

	public function test_activity_taxonomy_registered() {
		$this->assertTrue( taxonomy_exists( 'activity' ) );
	}

	public function test_facility_taxonomy_registered() {
		$this->assertTrue( taxonomy_exists( 'facility' ) );
	}

	public function test_location_taxonomy_registered() {
		$this->assertTrue( taxonomy_exists( 'location' ) );
	}

	public function test_park_type_taxonomy_registered() {
		$this->assertTrue( taxonomy_exists( 'park_type' ) );
	}

	public function test_taxonomies_attached_to_park_post_type() {
		$taxonomies = get_object_taxonomies( 'park' );
		$this->assertContains( 'activity', $taxonomies );
		$this->assertContains( 'facility', $taxonomies );
		$this->assertContains( 'location', $taxonomies );
		$this->assertContains( 'park_type', $taxonomies );
	}

	public function test_taxonomies_are_hierarchical() {
		$activity = get_taxonomy( 'activity' );
		$facility = get_taxonomy( 'facility' );
		$location = get_taxonomy( 'location' );
		$park_type = get_taxonomy( 'park_type' );
		
		$this->assertTrue( $activity->hierarchical );
		$this->assertTrue( $facility->hierarchical );
		$this->assertTrue( $location->hierarchical );
		$this->assertTrue( $park_type->hierarchical );
	}

	public function test_taxonomies_show_in_rest() {
		$activity = get_taxonomy( 'activity' );
		$facility = get_taxonomy( 'facility' );
		$location = get_taxonomy( 'location' );
		$park_type = get_taxonomy( 'park_type' );
		
		$this->assertTrue( $activity->show_in_rest );
		$this->assertTrue( $facility->show_in_rest );
		$this->assertTrue( $location->show_in_rest );
		$this->assertTrue( $park_type->show_in_rest );
	}
}
