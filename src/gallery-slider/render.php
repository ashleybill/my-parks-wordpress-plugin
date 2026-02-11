<?php
// Try block attribute first (if not empty), then fall back to ACF field
$gallery = ! empty( $attributes['images'] ) ? $attributes['images'] : get_field( "gallery", $block->context['postId'] ?? get_the_ID() );
if ( empty( $gallery ) ) {
	if ( is_admin() ) {
		// Show placeholder in editor
		?>
		<div <?php echo get_block_wrapper_attributes(); ?>>
			<p style="padding: 2rem; text-align: center; background: #f0f0f0; border: 1px dashed #ccc;">
				<?php _e( 'No gallery images found. Add images to the Gallery field.', 'my-parks' ); ?>
			</p>
		</div>
		<?php
		return;
	}
	return '';
}

$aspect_ratio = $attributes['aspectRatio'] ?? 'auto';
$autoplay = $attributes['autoplay'] ?? false;
$autoplay_speed = $attributes['autoplaySpeed'] ?? 5;
$image_count = count( $gallery );

$wrapper_attrs = get_block_wrapper_attributes();
if ( $aspect_ratio !== 'auto' ) {
	$wrapper_attrs = get_block_wrapper_attributes( array( 'data-aspect-ratio' => $aspect_ratio ) );
}
?>
<div <?php echo $wrapper_attrs; ?> data-autoplay="<?php echo $autoplay ? 'true' : 'false'; ?>" data-autoplay-speed="<?php echo esc_attr( $autoplay_speed ); ?>">
	<div class="glider-contain">
		<div class="glider">
			<?php 
			// ACF gallery returns array of attachment IDs or image arrays
			foreach ( $gallery as $image ) : 
				// Handle both ID and array formats
				if ( is_numeric( $image ) ) {
					$image_url = wp_get_attachment_image_url( $image, 'large' );
					$image_alt = get_post_meta( $image, '_wp_attachment_image_alt', true );
				} elseif ( is_array( $image ) ) {
					$image_url = $image['url'] ?? ( $image['sizes']['large'] ?? $image['url'] );
					$image_alt = $image['alt'] ?? '';
				} else {
					continue;
				}
				
				if ( $image_url ) : ?>
					<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" />
				<?php endif;
			endforeach; ?>
		</div>
		<?php if ( $image_count > 1 ) : ?>
			<button class="glider-prev" aria-label="Previous">‹</button>
			<button class="glider-next" aria-label="Next">›</button>
			<div class="glider-dots"></div>
		<?php endif; ?>
	</div>
</div>
