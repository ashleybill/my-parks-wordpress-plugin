<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * The following variables are exposed to the file:
 *     $attributes (array): The block attributes.
 *     $content (string): The block default content.
 *     $block (WP_Block): The block instance.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

$park_id = $attributes['parkId'] ?? 0;
if ( $park_id === 0 ) {
	$park_id = $block->context['postId'] ?? get_the_ID();
}

$advisory_lines = get_field( "park_advisories", $park_id );
$empty_message = $attributes['emptyMessage'] ?? 'There are currently no advisories.';

if ( empty( $advisory_lines ) ) {
	?>
	<div <?php echo get_block_wrapper_attributes(); ?>>
		<p><?php echo esc_html( $empty_message ); ?></p>
	</div>
	<?php
	return;
}

$summary_style = '';
$content_style = '';
$hover_styles = '';

if ( ! empty( $attributes['summaryTextColor'] ) ) {
	$summary_style .= 'color:' . esc_attr( $attributes['summaryTextColor'] ) . ';';
}
if ( ! empty( $attributes['summaryBackgroundColor'] ) ) {
	$summary_style .= 'background-color:' . esc_attr( $attributes['summaryBackgroundColor'] ) . ';';
}
if ( ! empty( $attributes['contentTextColor'] ) ) {
	$content_style .= 'color:' . esc_attr( $attributes['contentTextColor'] ) . ';';
}
if ( ! empty( $attributes['contentBackgroundColor'] ) ) {
	$content_style .= 'background-color:' . esc_attr( $attributes['contentBackgroundColor'] ) . ';';
}

if ( ! empty( $attributes['summaryHoverTextColor'] ) || ! empty( $attributes['summaryHoverBackgroundColor'] ) ) {
	$hover_styles = '<style>.wp-block-my-parks-advisories summary:hover{';
	if ( ! empty( $attributes['summaryHoverTextColor'] ) ) {
		$hover_styles .= 'color:' . esc_attr( $attributes['summaryHoverTextColor'] ) . '!important;';
	}
	if ( ! empty( $attributes['summaryHoverBackgroundColor'] ) ) {
		$hover_styles .= 'background-color:' . esc_attr( $attributes['summaryHoverBackgroundColor'] ) . '!important;';
	}
	$hover_styles .= '}</style>';
}
?>
<div <?php echo get_block_wrapper_attributes(); ?>>
	<?php echo $hover_styles; ?>
	<?php foreach ( $advisory_lines as $advisory_line ) : 
		$has_description = ! empty( $advisory_line['description'] );
		if ( $has_description ) : ?>
			<details>
				<summary<?php echo $summary_style ? ' style="' . $summary_style . '"' : ''; ?>>
					<?php echo esc_html( $advisory_line['title'] ); ?>
				</summary>
				<div class="accordion-content"<?php echo $content_style ? ' style="' . $content_style . '"' : ''; ?>>
					<p><?php echo esc_html( $advisory_line['description'] ); ?></p>
				</div>
			</details>
		<?php else : ?>
			<div class="accordion-item-no-content"<?php echo $summary_style ? ' style="' . $summary_style . '"' : ''; ?>>
				<?php echo esc_html( $advisory_line['title'] ); ?>
			</div>
		<?php endif;
	endforeach; ?>
</div>

