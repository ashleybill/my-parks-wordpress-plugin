<?php
/**
 * Register Custom Post Types
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function my_parks_register_post_types() {
	register_post_type( 'park', array(
		'labels' => array(
			'name' => __( 'Parks', 'my-parks' ),
			'singular_name' => __( 'Park', 'my-parks' ),
			'add_new' => __( 'Add New', 'my-parks' ),
			'add_new_item' => __( 'Add New Park', 'my-parks' ),
			'edit_item' => __( 'Edit Park', 'my-parks' ),
			'new_item' => __( 'New Park', 'my-parks' ),
			'view_item' => __( 'View Park', 'my-parks' ),
			'search_items' => __( 'Search Parks', 'my-parks' ),
			'not_found' => __( 'No parks found', 'my-parks' ),
			'not_found_in_trash' => __( 'No parks found in trash', 'my-parks' ),
		),
		'public' => true,
		'has_archive' => false,
		'show_in_rest' => true,
		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
		'menu_icon' => 'dashicons-palmtree',
		'rewrite' => array( 'slug' => 'parks' ),
	) );

	register_post_meta( 'park', 'cabin_booking_url', array(
		'type' => 'string',
		'single' => true,
		'show_in_rest' => true,
		'sanitize_callback' => 'esc_url_raw',
	) );
}
add_action( 'init', 'my_parks_register_post_types' );

function my_parks_add_cabin_url_meta_box() {
	add_meta_box(
		'cabin_booking_url',
		__( 'Cabin Booking URL', 'my-parks' ),
		'my_parks_cabin_url_meta_box_callback',
		'park',
		'side'
	);
}
add_action( 'add_meta_boxes', 'my_parks_add_cabin_url_meta_box' );

function my_parks_cabin_url_meta_box_callback( $post ) {
	wp_nonce_field( 'my_parks_cabin_url', 'my_parks_cabin_url_nonce' );
	$value = get_post_meta( $post->ID, 'cabin_booking_url', true );
	$cabin_term = get_term_by( 'slug', 'cabin', 'park_type' );
	$cabin_id = $cabin_term ? $cabin_term->term_id : '';
	?>
	<input type="url" name="cabin_booking_url" value="<?php echo esc_attr( $value ); ?>" style="width:100%" placeholder="https://" />
	<script>
	(function() {
		var metaBox = document.getElementById('cabin_booking_url');
		var cabinId = '<?php echo $cabin_id; ?>';
		var checkCabinType = function() {
			var checkboxes = document.querySelectorAll('input[name="tax_input[park_type][]"]');
			var cabinChecked = false;
			checkboxes.forEach(function(cb) {
				if (cb.value === cabinId && cb.checked) cabinChecked = true;
			});
			if (metaBox) metaBox.style.display = cabinChecked ? 'block' : 'none';
		};
		setTimeout(checkCabinType, 500);
		var checklist = document.getElementById('park_typechecklist');
		if (checklist) checklist.addEventListener('change', checkCabinType);
	})();
	</script>
	<?php
}

function my_parks_save_cabin_url( $post_id ) {
	if ( ! isset( $_POST['my_parks_cabin_url_nonce'] ) || ! wp_verify_nonce( $_POST['my_parks_cabin_url_nonce'], 'my_parks_cabin_url' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( isset( $_POST['cabin_booking_url'] ) ) {
		update_post_meta( $post_id, 'cabin_booking_url', esc_url_raw( $_POST['cabin_booking_url'] ) );
	}
}
add_action( 'save_post_park', 'my_parks_save_cabin_url' );
