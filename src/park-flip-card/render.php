<?php
$post_id = $block->context['postId'] ?? get_the_ID();
$featured_image = get_the_post_thumbnail_url( $post_id, 'large' );
$title = get_the_title( $post_id );
$excerpt = get_the_excerpt( $post_id );
$permalink = get_permalink( $post_id );

if ( ! $featured_image ) {
	$featured_image = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 300"%3E%3Crect fill="%23ddd" width="400" height="300"/%3E%3C/svg%3E';
}
?>
<div <?php echo get_block_wrapper_attributes(); ?>>
	<div class="flip-card-inner">
		<a href="<?php echo esc_url( $permalink ); ?>" class="flip-card-front" style="background-image: url('<?php echo esc_url( $featured_image ); ?>');">
			<div class="flip-card-overlay">
				<h3><?php echo esc_html( $title ); ?></h3>
			</div>
		</a>
		<div class="flip-card-back">
			<div class="flip-card-content">
				<h3><?php echo esc_html( $title ); ?></h3>
				<?php if ( $excerpt ) : ?>
					<p><?php echo esc_html( $excerpt ); ?></p>
				<?php endif; ?>
				<a href="<?php echo esc_url( $permalink ); ?>" class="flip-card-button">Learn More</a>
			</div>
		</div>
	</div>
</div>
