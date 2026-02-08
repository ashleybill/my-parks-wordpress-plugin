<?php
$operational_dates = get_field( "operational_dates", $block->context['postId'] ?? get_the_ID() );
if ( empty( $operational_dates ) ) {
	return '';
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
	$hover_styles = '<style>.wp-block-my-parks-operational-dates summary:hover{';
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
	<?php foreach ( $operational_dates as $date ) : 
		$has_details = ! empty( $date['details'] );
		if ( $has_details ) : ?>
			<details>
				<summary<?php echo $summary_style ? ' style="' . $summary_style . '"' : ''; ?>>
					<span class="facility-name"><?php echo esc_html( $date['facilityservicearea'] ); ?></span>
					<span class="date-range"><?php echo esc_html( $date['from'] ); ?> - <?php echo esc_html( $date['to'] ); ?></span>
				</summary>
				<div class="accordion-content"<?php echo $content_style ? ' style="' . $content_style . '"' : ''; ?>>
					<p><?php echo esc_html( $date['details'] ); ?></p>
				</div>
			</details>
		<?php else : ?>
			<div class="accordion-item-no-content"<?php echo $summary_style ? ' style="' . $summary_style . '"' : ''; ?>>
				<span class="facility-name"><?php echo esc_html( $date['facilityservicearea'] ); ?></span>
				<span class="date-range"><?php echo esc_html( $date['from'] ); ?> - <?php echo esc_html( $date['to'] ); ?></span>
			</div>
		<?php endif;
	endforeach; ?>
</div>
