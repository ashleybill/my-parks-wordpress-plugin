<?php
$about_short = get_field( "about_short", $block->context['postId'] ?? get_the_ID() );
if ( empty( $about_short ) ) {
	return '';
}
?>
<div <?php echo get_block_wrapper_attributes(); ?>><?php echo wp_kses_post( $about_short ); ?></div>
