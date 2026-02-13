<?php
/**
 * Plugin Name:       My Parks
 * Description:       Manage Blocks for Park type posts
 * Version:           0.8.0
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