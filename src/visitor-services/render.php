<?php
$visitor_services = get_field( "visitor_services", $block->context['postId'] ?? get_the_ID() );
$default_text = $attributes['defaultText'] ?? '';

// Use visitor services field if available, otherwise use default text
$content = !empty( $visitor_services ) ? $visitor_services : $default_text;

if ( empty( $content ) ) {
	return '';
}

// Handle WYSIWYG content vs plain text
if ( $content === $visitor_services && !empty( $visitor_services ) ) {
	// This is WYSIWYG content from ACF, output as-is
	$output = $content;
} else {
	// This is plain text (default text), convert line breaks
	$output = nl2br( esc_html( $content ) );
}
?>
<div <?php echo get_block_wrapper_attributes(); ?>><?php echo $output; ?></div>
