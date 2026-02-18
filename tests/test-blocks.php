<?php

class Test_Blocks extends WP_UnitTestCase {

	public function test_blocks_manifest_exists() {
		$manifest_path = dirname( dirname( __FILE__ ) ) . '/build/blocks-manifest.php';
		$this->assertFileExists( $manifest_path, 'Blocks manifest file does not exist. Run npm run build.' );
	}

	public function test_block_json_files_exist() {
		$expected_blocks = [
			'about-continued',
			'about-short',
			'advisories',
			'contact-tabs',
			'gallery-slider',
			'operational-dates',
			'park-flip-card',
			'park-search-filter',
			'park-taxonomy-filter',
			'rates',
			'taxonomy-icons',
			'visitor-services',
		];

		foreach ( $expected_blocks as $block ) {
			$block_json = dirname( dirname( __FILE__ ) ) . "/src/$block/block.json";
			$this->assertFileExists( $block_json, "Block $block/block.json does not exist" );
		}
	}

	public function test_custom_block_category_exists() {
		$categories = get_block_categories( get_post( 1 ) );
		$category_slugs = wp_list_pluck( $categories, 'slug' );
		$this->assertContains( 'my-park-blocks', $category_slugs );
	}
}
