<?php
$visitor_services = get_field( "visitor_services", $block->context['postId'] ?? get_the_ID() );
$default_text = $attributes['defaultText'] ?? '';

// Use visitor services field if available, otherwise use default text
$content = !empty( $visitor_services ) ? $visitor_services : $default_text;

if ( empty( $content ) ) {
	return '';
}
?>
<p <?php echo get_block_wrapper_attributes(); ?>><?php echo nl2br( esc_html( $content ) ); ?></p>
