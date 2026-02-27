<?php
/**
 * Plugin Name:       My Parks
 * Description:       Manage Blocks for Park type posts
 * Version:           0.11.3
 * Requires at least: 6.8
 * Requires PHP:      7.4
 * Author:            AJB
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       my-parks
 *
 * @package MyPark
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Include modular files
require_once __DIR__ . '/includes/post-types.php';
require_once __DIR__ . '/includes/taxonomies.php';
require_once __DIR__ . '/includes/field-groups.php';
require_once __DIR__ . '/includes/patterns.php';
require_once __DIR__ . '/includes/search-filter.php';
require_once __DIR__ . '/includes/shortcodes.php';

/**
 * Check if SCF is active
 */
function my_parks_check_scf_dependency() {
	if ( ! function_exists( 'get_field' ) ) {
		add_action( 'admin_notices', 'my_parks_scf_missing_notice' );
		return false;
	}
	return true;
}

/**
 * Display admin notice if SCF is missing
 */
function my_parks_scf_missing_notice() {
	$plugin_slug = 'secure-custom-fields';
	$install_url = wp_nonce_url(
		self_admin_url( 'update.php?action=install-plugin&plugin=' . $plugin_slug ),
		'install-plugin_' . $plugin_slug
	);
	$activate_url = wp_nonce_url(
		self_admin_url( 'plugins.php?action=activate&plugin=secure-custom-fields/secure-custom-fields.php' ),
		'activate-plugin_secure-custom-fields/secure-custom-fields.php'
	);
	
	// Check if SCF is installed but not activated
	$plugin_path = 'secure-custom-fields/secure-custom-fields.php';
	$is_installed = file_exists( WP_PLUGIN_DIR . '/' . $plugin_path );
	
	?>
	<div class="notice notice-error">
		<p>
			<?php _e( 'My Parks plugin requires Secure Custom Fields (SCF) to be installed and activated.', 'my-parks' ); ?>
		</p>
		<p>
			<?php if ( $is_installed ) : ?>
				<a href="<?php echo esc_url( $activate_url ); ?>" class="button button-primary"><?php _e( 'Activate SCF', 'my-parks' ); ?></a>
			<?php else : ?>
				<a href="<?php echo esc_url( $install_url ); ?>" class="button button-primary"><?php _e( 'Install SCF', 'my-parks' ); ?></a>
			<?php endif; ?>
		</p>
	</div>
	<?php
}

/**
 * Registers the block(s) metadata from the `blocks-manifest.php` and registers the block type(s)
 * based on the registered block metadata. Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://make.wordpress.org/core/2025/03/13/more-efficient-block-type-registration-in-6-8/
 * @see https://make.wordpress.org/core/2024/10/17/new-block-type-registration-apis-to-improve-performance-in-wordpress-6-7/
 */
function my_parks_block_init() {
	if ( ! my_parks_check_scf_dependency() ) {
		return;
	}
	wp_register_block_types_from_metadata_collection( __DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php' );
	
	// Only enqueue global styles if file exists
	if ( file_exists( __DIR__ . '/build/assets/style.css' ) ) {
		wp_enqueue_style( 'my-parks-global', plugin_dir_url( __FILE__ ) . 'build/assets/style.css' );
	}
}
add_action( 'init', 'my_parks_block_init' );


function my_parks_block_categories( $categories, $editor_context ) {
    // Add a new category
    $custom_category = array(
        'slug' => 'my-park-blocks', // A unique identifier (slug)
        'title' => 'Parks', // The display name
        'icon' => 'home', // Optional Dashicon slug or custom SVG
    );

    // Merge the new category with existing ones
    return array_merge( $categories, [ $custom_category ] );
}
add_filter( 'block_categories_all', 'my_parks_block_categories', 10, 2 );

/**
 * Sync ACF fields to post_content for Yoast SEO analysis
 */
function my_parks_sync_content_on_save( $post_id ) {
	if ( get_post_type( $post_id ) !== 'park' ) {
		return;
	}
	
	$about_short = get_field( 'about_short', $post_id );
	$about_continued = get_field( 'about_continued', $post_id );
	$visitor_services = get_field( 'visitor_services', $post_id );
	
	$content = '';
	if ( $about_short ) $content .= wp_strip_all_tags( $about_short ) . ' ';
	if ( $about_continued ) $content .= wp_strip_all_tags( $about_continued ) . ' ';
	if ( $visitor_services ) $content .= wp_strip_all_tags( $visitor_services ) . ' ';
	
	if ( $content ) {
		remove_action( 'acf/save_post', 'my_parks_sync_content_on_save', 20 );
		wp_update_post( array(
			'ID' => $post_id,
			'post_content' => trim( $content )
		) );
		add_action( 'acf/save_post', 'my_parks_sync_content_on_save', 20 );
	}
}
add_action( 'acf/save_post', 'my_parks_sync_content_on_save', 20 );

/**
 * Add ACF content to Yoast analysis
 */
function my_parks_yoast_content_filter( $content, $post ) {
	if ( ! $post || get_post_type( $post ) !== 'park' ) {
		return $content;
	}
	
	$about_short = get_field( 'about_short', $post->ID );
	$about_continued = get_field( 'about_continued', $post->ID );
	$visitor_services = get_field( 'visitor_services', $post->ID );
	
	$acf_content = '';
	if ( $about_short ) $acf_content .= wp_strip_all_tags( $about_short ) . ' ';
	if ( $about_continued ) $acf_content .= wp_strip_all_tags( $about_continued ) . ' ';
	if ( $visitor_services ) $acf_content .= wp_strip_all_tags( $visitor_services ) . ' ';
	
	return $content . ' ' . trim( $acf_content );
}
add_filter( 'wpseo_pre_analysis_post_content', 'my_parks_yoast_content_filter', 10, 2 );

/**
 * Yoast SEO integration for ACF content
 */
function my_parks_yoast_admin_script() {
	$screen = get_current_screen();
	if ( ! $screen || $screen->post_type !== 'park' || $screen->base !== 'post' || ! defined( 'WPSEO_VERSION' ) ) {
		return;
	}
	
	global $post;
	if ( ! $post || ! $post->ID ) return;
	
	$about_short = get_field( 'about_short', $post->ID );
	$about_continued = get_field( 'about_continued', $post->ID );
	$visitor_services = get_field( 'visitor_services', $post->ID );
	
	$content = '';
	if ( $about_short ) $content .= wp_strip_all_tags( $about_short ) . ' ';
	if ( $about_continued ) $content .= wp_strip_all_tags( $about_continued ) . ' ';
	if ( $visitor_services ) $content .= wp_strip_all_tags( $visitor_services ) . ' ';
	
	if ( ! $content ) return;
	
	$content = trim( $content );
	
	?>
	<script>
	(function() {
		var content = <?php echo json_encode( $content ); ?>;
		
		// Yoast loads after page load, so use delayed registration
		setTimeout(function() {
			if ( typeof YoastSEO !== 'undefined' && typeof YoastSEO.app !== 'undefined' ) {
				YoastSEO.app.registerPlugin( 'myParksPlugin', { status: 'ready' } );
				YoastSEO.app.registerModification( 'content', function( data ) {
					return data + ' ' + content;
				}, 'myParksPlugin', 5 );
			}
		}, 2000);
	})();
	</script>
	<?php
}
add_action( 'admin_footer', 'my_parks_yoast_admin_script' );