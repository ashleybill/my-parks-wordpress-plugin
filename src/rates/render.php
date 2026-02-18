<?php
$rates = get_field( "rates", $block->context['postId'] ?? get_the_ID() );
$default_text = $attributes['defaultText'] ?? '';

// Use rates field if available, otherwise use default text
if ( empty( $rates ) ) {
	if ( empty( $default_text ) ) {
		return '';
	}
	// Display default text
	?>
	<div <?php echo get_block_wrapper_attributes(); ?>>
		<p><?php echo nl2br( esc_html( $default_text ) ); ?></p>
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
	$hover_styles = '<style>.wp-block-my-parks-rates summary:hover{';
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
	<?php foreach ( $rates as $rate ) : 
		$has_breakdown = ! empty( $rate['breakdown'] );
		if ( $has_breakdown ) : ?>
			<details>
				<summary<?php echo $summary_style ? ' style="' . $summary_style . '"' : ''; ?>>
					<?php echo esc_html( $rate['fee_type'] ); ?>
				</summary>
				<div class="accordion-content"<?php echo $content_style ? ' style="' . $content_style . '"' : ''; ?>>
					<div class="rates-list">
						<?php foreach ( $rate['breakdown'] as $breakdown_item ) : ?>
							<div class="rate-item">
								<div class="rate-type"><?php echo esc_html( $breakdown_item['rate_type'] ); ?></div>
								<div class="rate-amount"><?php echo esc_html( $breakdown_item['rate_amount'] ); ?></div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</details>
		<?php else : ?>
			<div class="accordion-item-no-content"<?php echo $summary_style ? ' style="' . $summary_style . '"' : ''; ?>>
				<?php echo esc_html( $rate['fee_type'] ); ?>
			</div>
		<?php endif;
	endforeach; ?>
</div>
