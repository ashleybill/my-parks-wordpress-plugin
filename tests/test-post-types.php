<?php

class Test_Post_Types extends WP_UnitTestCase {

	public function test_park_post_type_registered() {
		$this->assertTrue( post_type_exists( 'park' ) );
	}

	public function test_park_post_type_is_public() {
		$post_type = get_post_type_object( 'park' );
		$this->assertTrue( $post_type->public );
	}

	public function test_park_post_type_has_no_archive() {
		$post_type = get_post_type_object( 'park' );
		$this->assertFalse( $post_type->has_archive );
	}

	public function test_park_post_type_shows_in_rest() {
		$post_type = get_post_type_object( 'park' );
		$this->assertTrue( $post_type->show_in_rest );
	}

	public function test_park_post_type_supports_features() {
		$this->assertTrue( post_type_supports( 'park', 'title' ) );
		$this->assertTrue( post_type_supports( 'park', 'thumbnail' ) );
		$this->assertTrue( post_type_supports( 'park', 'excerpt' ) );
		$this->assertFalse( post_type_supports( 'park', 'editor' ) );
		$this->assertFalse( post_type_supports( 'park', 'author' ) );
	}
}
