<?php
$visitor_services = get_field( "visitor_services", $block->context['postId'] ?? get_the_ID() );
if ( empty( $visitor_services ) ) {
	return '';
}
?>
<p <?php echo get_block_wrapper_attributes(); ?>><?php echo nl2br( esc_html( $visitor_services ) ); ?></p>
