<?php
$about_continued = get_field( "about_continued", $block->context['postId'] ?? get_the_ID() );
if ( empty( $about_continued ) ) {
	return '';
}
?>
<div <?php echo get_block_wrapper_attributes(); ?>><?php echo wp_kses_post( $about_continued ); ?></div>
