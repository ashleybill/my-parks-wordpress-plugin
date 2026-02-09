<?php
$post_id = $block->context['postId'] ?? get_the_ID();
$taxonomy = $attributes['taxonomy'] ?? 'activity';
$max_per_row = $attributes['maxPerRow'] ?? 6;

$terms = get_the_terms( $post_id, $taxonomy );
if ( empty( $terms ) || is_wp_error( $terms ) ) {
	return '';
}

$icon_width = 100 / $max_per_row;
?>
<div <?php echo get_block_wrapper_attributes( array( 'style' => '--max-per-row: ' . $max_per_row ) ); ?>>
	<?php foreach ( $terms as $term ) : 
		$icon = get_field( 'icon', $term );
		if ( $icon ) :
			$icon_url = is_array( $icon ) ? $icon['url'] : $icon;
			if ( $icon_url ) : ?>
				<div class="taxonomy-icon-item">
					<img src="<?php echo esc_url( $icon_url ); ?>" alt="<?php echo esc_attr( $term->name ); ?>" />
					<span class="taxonomy-icon-label"><?php echo esc_html( $term->name ); ?></span>
				</div>
			<?php endif;
		endif;
	endforeach; ?>
</div>
